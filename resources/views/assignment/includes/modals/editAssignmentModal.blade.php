<div class="modal-header">
    <h5 class="modal-title" id="exampleModalLabel">Редактирование поручения</h5>
    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
        <img src="{{ asset('img/icon/close.svg') }}" alt="Close">
    </button>
</div>
<div class="d-flex justify-content-center mt-5 spinner-wrapper b-hide" >
    <div class="spinner-grow text-primary" role="status">
        <span class="sr-only">Loading...</span>
    </div>
</div>
<form method="post" id="edit-assignment" action="">
    @csrf
    @method('put')

    <div class="modal-body">
        <div class="form-group form-group_department">
            <select class="form-control departmentSelect" id="department-select" name="department"
                    data-size="6" title="Выберите подразделение" data-header="Подразделение">
            </select>
        </div>
        <div class="form-group">
            <small id="preambuleHelp" class="form-text text-muted">Преамбула</small>
            <textarea class="form-control" id="preambule" name="preambule" rows="3">{{ old('preambule') }}</textarea>
        </div>
        <div class="form-group">
            <small id="resolutionHelp" class="form-text text-muted">Текст резолюции</small>
            <textarea class="form-control" id="resolution" name="resolution"
                      rows="5">{{ old('resolution') }}</textarea>
        </div>
        <div class="form-row">
            <div class="col">
                <small id="documentNumberHelp" class="form-text text-muted">Номер документа</small>
                <input type="number" class="form-control" id="document_number" name="document_number">
            </div>
            <div class="col">
                <small id="registerDateHelp" class="form-text text-muted">Дата регистрации</small>
                <input type="date" class="form-control" name="register-date" id="register-date">
            </div>
        </div>
        <div class="form-row">
            <div class="col">
                <small id="authorHelp" class="form-text text-muted">Автор резолюции</small>
                <select class="form-control authorSelect" id="author-select" name="author">
                    <option>Выберите автора...</option>
                </select>
            </div>
            <div class="col">
                <small id="addressedHelp" class="form-text text-muted">Кому адресована</small>
                <select class="form-control addressedSelect" id="addressed-select" name="addressed">
                    <option>Выберите адресата...</option>
                </select>
            </div>
        </div>
        <div class="form-group">
            <small id="departmentHelp" class="form-text text-muted">Ответственный исполнитель</small>
            <select class="form-control executorSelect" id="executor-select" name="executor"
                    title="Выберите исполнителя" data-header="Исполнитель" data-live-search="true">
            </select>
        </div>
        <div class="form-group">
            <small id="departmentHelp" class="form-text text-muted">Соисполнители</small>
            <select class="form-control subexecutors show-tick" id="subexecutors-select" title="Выберите соисполнителей"
                    name="subexecutors[]"
                    data-size="5" data-header="Выберите соисполнителя" data-live-search="true" multiple>
            </select>
        </div>
        <div class="form-row">
            <div class="col">
                <small id="deadlineHelp" class="form-text text-muted">Срок исполнения</small>
                <input type="date" class="form-control" id="deadline" name="deadline">
            </div>
            <div class="col">
                <small id="factdeadlineHelp" class="form-text text-muted">Фактический срок
                    исполнения</small>
                <input type="date" class="form-control" id="fact-deadline" name="fact_deadline">
            </div>
            <div class="col">
                <small id="statusHelp" class="form-text text-muted">Статус</small>
                <select class="form-control statusSelect" id="status-select" name="status" title="Статус">
                </select>
            </div>
        </div>
    </div>
    <div class="modal-footer">
        <button type="button" class="btn btn-danger" data-dismiss="modal">Отменить</button>
        <button type="submit" class="btn btn-primary">Сохранить изменения</button>
    </div>
</form>
