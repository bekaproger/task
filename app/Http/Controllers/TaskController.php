<?php

namespace App\Http\Controllers;

use App\Http\Validation\TaskValidator;
use App\Model\Task;
use App\Model\User;
use Doctrine\ORM\Tools\Pagination\Paginator;
use Lil\Http\AbstractController;
use Lil\Http\Request;
use Lil\Http\ValidationException;
use Symfony\Component\HttpFoundation\JsonResponse;

class TaskController extends AbstractController
{
    private $available_sorts = ['username', 'email'];

    private $available_sort_directions = ['asc', 'desc'];

    public function index(Request $request)
    {
        $sort = $request->query->get('sort', null);
        $direction = $request->query->get('direction', 'asc');
        $only_finished = $request->query->get('only-finished', null);
        $message = null;
        $qb = $this->getManager()
            ->createQueryBuilder()
            ->select('task')
            ->from('App\Model\Task', 'task');

        if ($sort && !in_array($sort, $this->available_sorts)) {
            $message = 'invalid sort parameter';
        }

        if ($sort && $direction && !in_array($direction, $this->available_sort_directions)) {
            $message = 'invalid direction parameter';
        }

        if (!empty($message)) {
            $request->setValidationErrors(['sort' => $message]);
            throw new ValidationException();
        }

        if ($sort && $direction) {
            $qb->orderBy('task.'.$sort, $direction);
        }

        if (in_array($only_finished, ['true', 'false'])) {
            $qb->where('task.finished = :finished');
            $qb->setParameter('finished', 'true' === $only_finished ? 1 : 0);
        }

        $page = $request->query->getInt('page', 1);
        $per_page = 3;

        // If page is 1 the offset must be 0
        // if page greater than 1 (for example 2)
        // the offset must be = (page - 1) * per_page
        $first_res = $page <= 1 ? 0 : $per_page * ($page - 1);

        $query = $qb->getQuery()
            ->setFirstResult($first_res)
            ->setMaxResults($per_page);

        $paginator = new Paginator($query, $fetchJoinCollection = false);

        $tasks = [];

        /**
         * @var $task Task
         */
        foreach ($paginator as $task) {
            $tasks[] = [
                'id' => $task->getId(),
                'username' => $task->getUsername(),
                'email' => $task->getEmail(),
                'task' => $task->getTask(),
                'finished' => $task->getFinished(),
                'edited_by_admin' => $task->getEditedByAdmin(),
            ];
        }

        $data = ['data' => $tasks, 'total' => $paginator->count(), 'current_page' => $page, 'per_page' => $per_page];

        return new JsonResponse($data);
    }

    public function create()
    {
        return view('tasks.create');
    }

    public function store(Request $request, TaskValidator $validator)
    {
        $this->validate($request, $validator);

        $task = new Task();
        $task->setEmail($request->request->get('email'));
        $task->setUsername($request->request->get('username'));
        $task->setTask($request->request->get('task'));
        $task->setFinished(false);
        $task->setEditedByAdmin(false);

        $this->getManager()->persist($task);
        $this->getManager()->flush();

        $request->setRequestSessionData(1, ['alerts' => ['Task has been created!']]);
        return redirect('/');
    }

    public function finish($id)
    {
        $user = auth()->user();
        /**
         * @var $task Task
         */
        $task = $this->getManager()->getRepository(Task::class)->find($id);
        if (!$task) {
            return view('404', [], 404);
        }

        $task->setFinished(true);
        if ($user && $user->getIsAdmin()) {
            $task->setEditedByAdmin(true);
        }

        $this->getManager()->flush();

        return view('index');
    }

    public function unfinish($id)
    {
        /**
         * @var $user User
         */
        $user = auth()->user();

        /**
         * @var $task Task
         */
        $task = $this->getManager()->getRepository(Task::class)->find($id);

        $task->setFinished(false);
        if ($user && $user->getIsAdmin()) {
            $task->setEditedByAdmin(true);
        }

        $this->getManager()->flush();

        return view('index');
    }

    public function delete($id)
    {
        $user = auth()->user();
        /**
         * @var $task Task
         */
        $task = $this->getManager()->getRepository(Task::class)->find($id);
        if (!$task) {
            return view('404', [], 404);
        }
        $this->getManager()->remove($task);
        $this->getManager()->flush();

        return new JsonResponse(['ok' => true], 201);
    }

    public function edit($id)
    {
        $task = $this->getManager()->getRepository(Task::class)->find($id);
        if (!$task) {
            return view('404', [], 404);
        }

        return view('tasks.edit', ['task' => $task]);
    }

    public function update(Request $request, TaskValidator $validator, $id)
    {
        $this->validate($request, $validator);

        $user = auth()->user();

        /**
         * @var $task Task
         */
        $task = $this->getManager()->getRepository(Task::class)->find($id);

        if (!$task) {
            return view('404', [], 404);
        }

        $task->setEmail($request->request->get('email'));
        $task->setUsername($request->request->get('username'));
        $task->setTask($request->request->get('task'));
        if ($user && $user->getIsAdmin()) {
            $task->setEditedByAdmin(true);
        }

        $this->getManager()->persist($task);
        $this->getManager()->flush();

        $request->setRequestSessionData(1, ['alerts' => ['Task has been edited!']]);
        return redirect('/');
    }
}
