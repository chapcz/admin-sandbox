$(function () {
    $.nette.init();
    $('[data-dependentselectbox]').dependentSelectBox();
});

LiveForm.setOptions({
    messageErrorPrefix: '',
    wait: 1000
});
