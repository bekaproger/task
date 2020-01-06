<!DOCTYPE html>

<html>
<head>
    <meta name="is-authorized" data-is-authorized="<?= auth()->user() ? 1 : 0 ?>">
</head>
<body>
<div class="container">
    <div style="display: none;" class="alert alert-primary" role="alert">

    </div>
    <div class="row">
        <div class="col-md-3">
            <p> Hello <?php auth()->user() ?  e(auth()->user()->getName()) : '' ?></p>
            <?php if (auth()->user()) {?>
            <form action="/logout" method="POST">
                <input class="btn btn-primary" type="submit" value="logout">
            </form>
            <?php } else { ?>
                <a class="btn btn-primary" href="/login">
                    Войти
                </a>
            <?php } ?>
        </div>
        <div class="col-md-3">
            <form class="sort-form">
                <select class="direction" name="direction">
                    <option value="">---</option>
                    <option value="asc">asc</option>
                    <option value="desc">desc</option>
                </select>
                <select class="sort" name="sort">
                    <option value="">---</option>
                    <option value="email">email</option>
                    <option value="username">username</option>
                </select>
                <input class="btn btn-primary" type="submit" value="sort">
            </form>
        </div>
        <div class="col-md-3">
            <label>
                Only finished
                <input class="status-filter-input" type="checkbox">
            </label>
            <button class="reset-status-filter btn btn-primary">Reset</button>
        </div>
        <div class="col-md-3" style="text-align: right;">
            <a class="btn btn-primary" href="/tasks/create">Create</a>
        </div>
    </div>
    <div class="row justify-content-md-center" style="padding-top: 20px; ">
        <table class="table">
            <thead>
            <tr>
                <th scope="col">#</th>
                <th scope="col">Task</th>
                <th scope="col">Username</th>
                <th scope="col">Email</th>
                <th scope="col">Edited by admin</th>
                <th scope="col">Status</th>
                <th class="actions-header" scope="col">Actions</th>
            </tr>
            </thead>
            <tbody class="tasks-table-body">
            <tr class="task-row original" style="display: none;">
                <th class="id" scope="row">1</th>
                <td class="task"></td>
                <td class="username"></td>
                <td class="email"></td>
                <td class="edited_by_admin"></td>
                <td class="finished">
                    <button data-current-page="" data-href="" class="finish-btn btn">
                        Finish
                    </button>
                </td>
                <td class="actions">
                    <button data-current-page="" data-href="" class="delete-btn btn btn-small btn-danger">
                        Delete
                    </button>
                    <a href="" class="edit-btn btn-small btn btn-primary">
                        Edit
                    </a>
                </td>
            </tr>
            </tbody>
        </table>

        <nav>
            <ul class="pagination"></ul>
        </nav>

    </div>
</div>
<? include 'layout.php'?>

<script type="text/javascript">
  $(document).ready(function () {
    request(1);

    function showAlert(text) {
      let alert = $('.alert')
      alert.text(text).show();
      let time = setTimeout(function() {
        alert.text('');
        alert.hide()
        clearTimeout(this)
      }, 3000)
    }

    function request(page, sort, direction, filter) {
      page = page !== undefined ? page : 1;
      sort = sort !== undefined ? sort : $('.sort').val();
      direction = direction !== undefined ? direction : $('.direction').val();
      filter = filter !== undefined ? filter : '';

      $.ajax({
        type: 'GET',
        url : '/tasks?page=' + page + '&sort=' + sort + '&direction=' + direction + '&only-finished=' + filter
      }).done(function (res) {
        createTable(res.data, res.current_page)
        if (res.total > res.per_page) {
          setPagination(res.total, res.current_page, res.per_page)
        }
      })
    }

    function checkAuthorized() {
      return $("meta[name='is-authorized']").attr('data-is-authorized') == 1;
    }

    function refreshTable(){
      $('.task-row:not(.original)').remove();
      $('.pagination').children().remove();
    }

    function getCurrentPagination() {
      return $('.page-item.active').children('.page-link').text();
    }

    function getStatusFilterValue() {
      let sort_input = $('.status-filter-input');
      return sort_input.attr('data-changed') === 'changed' ? sort_input.prop('checked') : '';
    }

    $('.sort-form').on('submit', function (e) {
      e.preventDefault();
      let page = getCurrentPagination();
      refreshTable();

      request(page, undefined, undefined, getStatusFilterValue());
    });

    $('.status-filter-input').on('change', function (e) {
      refreshTable();
      $(this).attr('data-changed', 'changed');
      request(undefined, undefined, undefined, $(this).prop('checked'));
    });

    function setPagination(total, current, per_page) {
      let pagination = $('.pagination')
      let i = 1;
      total = Math.ceil(total /per_page)
      while (i <= total) {
        let item = $('<li></li>')
        item.addClass('page-item')
        if (i === current) {
          item.addClass('active');
        }
        let link = $('<a></a>')
        link.addClass('page-link')
        link.attr('href', '/tasks?page=' + i);
        link.text(i)
        item.append(link);

        pagination.append(item)
        i++;
      }
    }

    function createTable(tasks, current) {
      let delete_btn;
      let finished_btn;
      let edit_btn;
      for (let i = 0; i < tasks.length; i++) {
        let original = $('.task-row.original');
        let clone = original.clone();

        let task = tasks[i];
        clone.children('.id').text(task.id);
        clone.children('.task').text(task.task)
        clone.children('.email').text(task.email)
        clone.children('.username').text(task.username)
        clone.children('.edited_by_admin').text(task.edited_by_admin ? 'Да' : 'Нет')
        finished_btn = clone.children('.finished').children('.finish-btn');
        finished_btn.attr('data-current-page', current)
        if (task.finished) {
          finished_btn.addClass('btn-success')
          finished_btn.text('Finished')
          finished_btn.attr('data-href', '/tasks/' + task.id + '/unfinish');
        } else {
          finished_btn.addClass('btn-primary')
          finished_btn.text('Finish')
          finished_btn.attr('data-href', '/tasks/' + task.id + '/finish');
        }

        if (checkAuthorized()) {
          delete_btn = clone.children('.actions').children('.delete-btn');
          delete_btn.attr('data-href', '/tasks/' + task.id);
          delete_btn.attr('data-current-page', current);
          edit_btn = clone.children('.actions').children('.edit-btn');
          edit_btn.attr('href', '/tasks/' + task.id + '/edit');
        } else {
          clone.children('.actions').remove();
          $('.actions-header').hide();
        }


        clone.removeClass('original');

        $('.tasks-table-body').append(clone);
        clone.show();
      }
    }

    $('.pagination').on('click', '.page-link', function (e) {
      e.preventDefault();
      $('.task-row:not(.original)').remove();
      $('.pagination').children().remove();
      request($(this).text());
    });

    $('.tasks-table-body').on('click', '.delete-btn', function(e) {
      e.preventDefault();
      if (!checkAuthorized()) {
        return
      }
      let th = $(this);
      let current_page = th.attr('data-current-page');
      let rows = $('.task-row:not(.original)');
      if (rows.length === 1 && current_page > 1) {
        current_page--;
      }
      $.ajax({
        url :  th.attr('data-href'),
        type: 'DELETE'
      }).done(function() {
        rows.remove();
        $('.pagination').children().remove();
        request(current_page);
        showAlert('Task has been deleted')
      }).fail(function () {
        alert('error')
      });
    });

    $('.tasks-table-body').on('click', '.finish-btn', function(e) {
      e.preventDefault();

      if(!checkAuthorized()) {
        return
      }
      let th = $(this);
      let current_page = th.attr('data-current-page');

      $.ajax({
        url :  th.attr('data-href'),
        type: 'POST'
      }).done(function() {
        $('.task-row:not(.original)').remove();
        $('.pagination').children().remove();
        request(current_page, undefined, undefined, getStatusFilterValue());
        showAlert('Task has been changed')
      }).fail(function () {
        alert('error')
      });
    })

    $('.reset-status-filter').on('click', function(e) {
      $('.status-filter-input').attr('data-changed', '').prop('checked', false);
      refreshTable()
      request();
    })

  })

</script>
</body>
</html>

