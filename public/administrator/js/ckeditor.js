import {
    ClassicEditor,
    SimpleUploadAdapter,
    MediaEmbed,
} from "ckeditor5";

document.addEventListener("DOMContentLoaded", function () {

    const textareas = document.querySelectorAll(".upload-ckeditor");

    textareas.forEach((textarea) => {

        ClassicEditor.create(textarea, {

            toolbar: [
                "mediaEmbed"
            ],

            plugins: [
                SimpleUploadAdapter,
                
            ],

            simpleUpload: {
                uploadUrl: `${window.location.origin}/administrator/ckeditor/upload?_token=${window.csrfToken}`,
            },

        })

        .then((editor) => {

            textarea.contentInstance = editor;

        })

        .catch((error) => {

            console.error(error);

        });

    });

});