<x-app-lay>
      <x-slot:title>
            KanbanBoard
      </x-slot:title>


      @push('scripts')
            <script>
                  var currentSection = '';
                  var addOrUpdate = null;
                  var selectedTask = null;

                  $(function() {
                        $.ajax({
                              type: 'get',
                              url: '{{ URL('kanban-board/get-all') }}',
                              success: function(data) {
                                    console.log(data);
                                    data.map(x => {
                                          appendItem(x);
                                    })
                              }
                        });
                  });


                  function appendItem(item) {
                        var newItem = `
                <div class="card mb-2 kanban-item">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-8">
                                <p id="taskName" item_id="${item.id}">${item.name}</p>
                            </div>
                            <div class="col-md-4">
                                <button class="btn btn-sm btn-warning edit-task"><i class='bx bx-comment-edit'></i></button>
                                <button class="btn btn-sm btn-danger delete-task"><i class='bx bx-comment-x'></i></button>
                            </div>
                        </div>
                    </div>
                </div>`;
                        $("#" + item.status).append(newItem);
                  }

                  function reOrderKanbanOrder() {
                        var tasks = [];
                        $('.connectedSortable').each(function() {
                              var sectionId = $(this).attr('id');
                              $(this).children('.kanban-item').each(function(index) {
                                    tasks.push({
                                          id: $(this).find("#taskName").attr('item_id'),
                                          name: $(this).find("#taskName").text(),
                                          status: sectionId,
                                          order: index
                                    });
                              });
                        });

                        $.post("{{ url('kanban-board/reorder') }}", {
                              _token: "{{ csrf_token() }}",
                              tasks: tasks
                        }, function(response) {
                              console.log(response);
                        });
                  }

                  $(".connectedSortable").sortable({
                        connectWith: ".connectedSortable",
                        items: "> .kanban-item",
                        placeholder: "ui-state-highlight",
                        update: reOrderKanbanOrder,
                  }).disableSelection();

                  function showTaskModal(section) {
                        currentSection = section;
                        addOrUpdate = 'add';
                        $('#taskModalLabel').text('Add Task');
                        $('#task-name').val('');
                        $('#taskModal').modal('show');
                  }

                  $('#save-task').click(function() {
                        var taskName = $('#task-name').val();

                        if (taskName) {
                              if (addOrUpdate == 'add') {
                                    $.post("{{ url('kanban-board/store') }}", {
                                          _token: "{{ csrf_token() }}",
                                          name: taskName,
                                          status: currentSection,
                                    }, function(response) {
                                          appendItem(response.item);
                                    });
                              } else {
                                    $.post("{{ url('kanban-board/update') }}", {
                                          _token: "{{ csrf_token() }}",
                                          name: taskName,
                                          id: selectedTask.attr('item_id'),
                                    }, function(response) {
                                          selectedTask.text(taskName);
                                    });
                              }

                              $('#taskModal').modal('hide');
                        }
                  });

                  $(document).on('click', '.edit-task', function() {
                        addOrUpdate = 'update';
                        selectedTask = $(this).parent().parent().find("#taskName");
                        $('#taskModalLabel').text('Edit Task');
                        $('#task-name').val(selectedTask.text());
                        $('#taskModal').modal('show');
                  });

                  $(document).on('click', '.delete-task', function() {
                        if (confirm('Are you sure you want to delete this task?')) {
                              let item = $(this);
                              $.post("{{ url('kanban-board/delete') }}", {
                                    _token: "{{ csrf_token() }}",
                                    id: item.parent().parent().find("#taskName").attr('item_id'),
                              }, function(response) {
                                    item.parent().parent().parent().remove();
                              });
                        }
                  });
            </script>
      @endpush
</x-app-lay>

