<div class="modal-header">
    <h5 class="modal-title" id="exampleModalLabel">Продлить поручение</h5>
    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
        <img src="{{ asset('img/icon/close.svg') }}" alt="close">
    </button>
</div>
<form method="post" action="#" id="extend-assignment-from">
    @csrf
    <div class="modal-body">
        <div class="form-group">
            <input type="date" class="form-control" id="deadline" name="deadline" min="@php echo date('Y-m-d') @endphp"
                   aria-describedby="deadlineHelp" value="{{ old('deadline') }}" required>
            <small id="fullnameHelp" class="form-text text-muted">Выберите дату исполнения</small>
        </div>
    </div>
    <div class="modal-footer">
        <button type="button" class="btn btn-danger" data-dismiss="modal">Отменить</button>
        <button type="" class="btn btn-primary">Продлить поручение</button>
    </div>
</form>


