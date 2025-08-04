<x-app-lay>
      <x-slot:title>
            KanbanBoard
      </x-slot:title>


      @push('scripts')
            <script>
                  var currentSection = '';
                  var addOrUpdate = null;
                  var selectedTask = null;
                  var subtasks = {{ $subtasks ? : null }}
                  $(function() {
                        //add data subtask to kanban
                        subtasks.map(x =>{
                              appendItem(subtasks)
                        })
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

            </script>
      @endpush
</x-app-lay>

