<div class="modal-header">
    <h5 class="modal-title" id="exampleModalLabel">Экспорт данных</h5>
    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
        <img src="{{ asset('img/icon/close.svg') }}" alt="close">
    </button>
</div>
<form method="get" action="{{ route('assignments.export') }}">
    @csrf
    <div class="modal-body">
        <div class="form-group">
            <small id="exportHelp" class="form-text text-muted">Выберите подразделение</small>
            <select class="form-control departmentSelect exportSelect" id="department-select" name="department"
                    data-size="10" title="Выберите подразделение" data-header="Подразделение">
            </select>
        </div>
    </div>
    <div class="modal-footer">
        <button type="button" class="btn btn-danger" data-dismiss="modal">Отменить</button>
        <button type="submit" class="btn btn-primary">Экспортировать</button>
    </div>
</form>
