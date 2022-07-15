<div class="modal-header">
    <h5 class="modal-title" id="exampleModalLabel">Добавление исполнителя</h5>
    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
        <img src="{{ asset('img/icon/close.svg') }}" alt="close">
    </button>
</div>
<form method="post" action="{{ route('assignments.user.add') }}">
    @csrf
    <div class="modal-body">
        <div class="form-group">
            <input type="text" class="form-control" id="full_name" name="full_name"
                   aria-describedby="fullnameHelp" value="{{ old('title') }}">
            <small id="fullnameHelp" class="form-text text-muted">Введите ФИО исполнителя</small>
        </div>
    </div>
    <div class="modal-footer">
        <button type="button" class="btn btn-danger" data-dismiss="modal">Отменить</button>
        <button type="submit" class="btn btn-primary">Сохранить</button>
    </div>
</form>


