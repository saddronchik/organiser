<div class="modal-header">
    <h5 class="modal-title" id="exampleModalLabel">Новое поручение</h5>
    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
        <img src="{{ asset('img/icon/close.svg') }}" alt="">
    </button>
</div>
<form method="post" id="add-assignment" action="{{ route('add-assignment') }}">
    @csrf
    <div class="modal-body">
        <div class="form-group form-group_department">
            <select class="form-control departmentSelect" id="department-select" name="department"
                    title="Выберите подразделение" data-header="Подразделение">
            </select>
            <img src="{{ asset('img/plus.png') }}" alt="add" class="addDepartmentInput" id="add-department-input">
            <div class="newDepartment">
                <small id="newDepartmentHelp" class="form-text text-muted">Новое подразделение</small>
                <div class="input-group">
                    <input type="text" class="form-control col-md-6 newDepartmentInput" name="new-department">
                    <img src="{{ asset('img/remove.png') }}" class="removeInput" alt="remove-input" height="18px">
                </div>

            </div>
        </div>
        <div class="form-group">
            <small id="preambuleHelp" class="form-text text-muted">Преамбула</small>
            <textarea class="form-control" id="preambule" name="preambule" rows="3"></textarea>
        </div>
        <div class="form-group">
            <small id="resolutionHelp" class="form-text text-muted">Текст резолюции</small>
            <textarea class="form-control" id="resolution" name="resolution"
                      rows="5"></textarea>
        </div>
        <div class="form-row">
            <div class="col">
                <small id="documentNumberHelp" class="form-text text-muted">Номер документа</small>
                <input type="number" class="form-control" name="document_number">
            </div>
            <div class="col">
                <small id="registerDateHelp" class="form-text text-muted">Дата регистрации</small>
                <input type="date" class="form-control" name="register-date">
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
            <select class="form-control subexecutors" id="subexecutors" title="Выберите соисполнителей"
                    name="subexecutors[]"
                    data-size="3" data-header="Выберите соисполнителя" data-live-search="true" multiple>
{{--                <option data-content="<span class='badge badge-primary'>Иванок И.К.</span>">Иванов И.К.--}}
{{--                </option>--}}
{{--                <option data-content="<span class='badge badge-primary'>Петров Е.М..</span>">Петров Е.М.--}}
{{--                </option>--}}
{{--                <option data-content="<span class='badge badge-primary'>Сидоров С.В.</span>">Сидоров--}}
{{--                    С.В.--}}
{{--                </option>--}}
{{--                <option data-content="<span class='badge badge-primary'>Черный Пистолет</span>" >Черный--}}
{{--                    Пистолет--}}
{{--                </option>--}}
            </select>
        </div>
        <div class="form-row">
            <div class="col">
                <small id="deadlineHelp" class="form-text text-muted">Срок исполнения</small>
                <input type="date" class="form-control" name="deadline">
            </div>
            <div class="col">
                <small id="factdeadlineHelp" class="form-text text-muted">Фактический срок
                    исполнения</small>
                <input type="date" class="form-control" name="fact_deadline">
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
        <button type="submit" class="btn btn-primary">Сохранить</button>
    </div>
</form>

