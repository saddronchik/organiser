
    <div class="modal fade" id="{{ $id }}" tabindex="-1" role="dialog" aria-labelledby="modal"
         aria-hidden="true">
        <div class="modal-dialog {{ $size }}" role="dialog">
            <div class="modal-content">
                @switch($id)
                    @case('executorModal')
                        @include('assignment.includes.modals.addUserModal')
                        @break
                    @case('departmentModal')
                        @include('assignment.includes.modals.addDepartmentModal')
                        @break
                    @case('add-assignment-modal')
                        @include('assignment.includes.modals.addAssignmentModal')
                @endswitch

            </div>
        </div>
    </div>

