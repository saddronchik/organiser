$('.dropdown-toggle').dropdown()

let searchBtn = document.querySelector('.search-icon');
let searchInput = document.querySelector('.search-input');

searchBtn.addEventListener('click', function (e) {
    searchInput.classList.toggle('b-show');
})

$('.departmentSelect').selectpicker();
$('.executorSelect').selectpicker();
$('.subexecutors').selectpicker();
$('.statusSelect').selectpicker();

$('#resolution').summernote({
    toolbar: [
        ['style', ['bold', 'italic', 'underline', 'clear']],
        ['font', ['strikethrough', 'superscript', 'subscript']],
        ['fontsize', ['fontsize']],
        ['color', ['color']],
        ['para', ['ul', 'ol', 'paragraph']],
        ['height', ['height']],
        ['view', ['fullscreen', 'codeview', 'help']],
    ]
});
