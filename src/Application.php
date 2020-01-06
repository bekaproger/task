<?php

namespace Lil;

use Lil\Container\Container;
use Lil\Http\RedirectableException;
use Lil\Http\ValidationException;
use Lil\Router\Interfaces\RouterInterface;
use Lil\Http\Request;
use Lil\Router\ResolvedController;

class Application extends Container implements ApplicationInterface
{
    protected $baseDir;

    protected static $instance;

    public function __construct(string $basedir, array $definitions = [])
    {
        parent::__construct($definitions);
        $this->baseDir = $basedir;
        self::$instance = $this;
        $this->resolveHelpers();
//        $this->initDefinitions();
    }

    public function handle(Request $request)
    {
        try {
            $request->setSession($this->get('session'));

            /**
             * @var $result ResolvedController
             */
            $result = $this->get(RouterInterface::class)->match($request);
            $result->execute($request);
        } catch (RedirectableException $e) {
            back($e->redirectTo())->send();
        } catch (ValidationException $e) {
            back()->send();
        } catch (\Exception $e) {
            echo $e->getMessage();
        }
    }

    public function getBaseDir(): string
    {
        return $this->baseDir;
    }

    public static function getInstance()
    {
        return self::$instance;
    }

    public function resolveClass($id)
    {
        if (self::class === $id) {
            return $this;
        }

        return parent::resolveClass($id);
    }

    protected function resolveHelpers()
    {
        require_once $this->baseDir.str_replace('/', DIRECTORY_SEPARATOR, '/src/Common/helpers.php');
    }

    public function make($id)
    {
        return parent::resolveClass($id);
    }
}
