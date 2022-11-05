import $ from 'jquery';
const page = '#page-custom';
const url = window.location.href;
const imageInputs = '.image-input';

$(document).ready(function() {
    setSections();
    setImagePreviewer();
});

function setSections(json = {}) {

    if ($(page).length > 0) {
        $.get(url, json, function(data, state){
            if (state === 'success') {
                console.log(data);
            }
        })
    }
}

function setImagePreviewer() {

    $(imageInputs).on('change', function(ev) {
        let elmt = this;
        let file = $(elmt).get(0).files[0];
        if(file){
            let reader = new FileReader();
            reader.onload = function(){
                $(elmt).next().attr("src", reader.result);
            }
            reader.readAsDataURL(file);
        }
    })
}