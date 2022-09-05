$("#rd2").hide();
$("#rd1").hide();
function select_radio(id) {
    if (id == 1) {
        $("#rd2").hide();
        $("#rd1").show();
    }
    if (id == 3) {
        $("#rd1").hide();
        $("#rd2").show();
    }
}

$("#tags").tagsInput({
    interactive: true,
    defaultText: "Add More",
    removeWithBackspace: true,
    width: "100%",
    height: "auto",
    placeholderColor: "#666666",
});
// Multi Select
if ($(".js-example-basic-single").length) {
    $(".js-example-basic-single").select2();
}

//Tinymce editor
if ($("#tinymceExample").length) {
    tinymce.init({
        selector: "#tinymceExample",
        height: 400,
        theme: "silver",
        plugins: [
            "advlist autolink lists link image charmap print preview hr anchor pagebreak",
            "searchreplace wordcount visualblocks visualchars code fullscreen",
        ],
        image_advtab: true,
        templates: [
            {
                title: "Test template 1",
                content: "Test 1",
            },
            {
                title: "Test template 2",
                content: "Test 2",
            },
        ],
        content_css: [],
    });
}

if ($("#tinymceExample1").length) {
    tinymce.init({
        selector: "#tinymceExample1",
        height: 400,
        theme: "silver",
        plugins: [
            "advlist autolink lists link image charmap print preview hr anchor pagebreak",
            "searchreplace wordcount visualblocks visualchars code fullscreen",
        ],
        image_advtab: true,
        templates: [
            {
                title: "Test template 1",
                content: "Test 1",
            },
            {
                title: "Test template 2",
                content: "Test 2",
            },
        ],
        content_css: [],
    });
}

