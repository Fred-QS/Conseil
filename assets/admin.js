// any CSS you import will output into a single css file (app.css in this case)
import './styles/sass/layout/_builder.scss';

import $ from 'jquery';
const page = '#page-custom';
const deploySection = '.deploy-section';
const sectionLister = '.section-lister';
const deleteSection = '.delete-section';
const sectionDivision = '.section-division';
const url = window.location.href;
const imageInputs = '.image-input';
const deleteModal = '#modal-delete';
const deleteCancel = '.modal-delete-cancel';
const deleteConfirm = '#modal-delete-button';
let sectionToDelete = null;

$(document).ready(function() {
    setImagePreviewer();
    setSectionEvents();
});

function setSectionEvents() {

    $(deploySection).off('click');
    $(deleteSection).off('click');
    $(deleteCancel).off('click');
    $(deleteConfirm).off('click');
    $(deleteModal).off('click');

    $(sectionLister + '.open').next().css({height: $(sectionLister + '.open').next().prop("scrollHeight") + 'px'})

    $(deploySection).on('click', function(){
        let parent = $(this).parents(sectionLister);
        if (!$(parent).hasClass('open')) {
            $(sectionLister).removeClass('open');
            $(sectionLister).next().css({height: 0});
            $(parent).addClass('open');
            $(parent).next().css({height: $(parent).next().prop("scrollHeight")})
        } else {
            $(sectionLister).removeClass('open');
            $(sectionLister).next().css({height: 0});
        }
    });

    $(deleteModal).on('click', function(ev){
        if (ev.target.id === 'modal-delete') {
            cancelDeleteModal();
        }
    });

    $(deleteSection).on('click', function(){
        sectionToDelete = +$(this).data('index');
        $(deleteModal).css({display: 'block'});
        $('body').append('<div class="modal-backdrop modal-delete-cancel fade"></div>');
        setTimeout(function(){
            $(deleteModal).addClass('show');
            $('.modal-backdrop').addClass('show');
        }, 50);
    });

    $(deleteCancel).on('click', function(){
        cancelDeleteModal();
    });

    $(deleteConfirm).on('click', function(){
        let lister = $(sectionLister + '[data-index="' + sectionToDelete + '"]'),
            division = $(sectionDivision + '[data-index="' + sectionToDelete + '"]');
        console.log(sectionToDelete);
        cancelDeleteModal();
        $(lister).remove();
        $(division).remove();
    });
}

function deleteBackdrop() {
    $('.modal-backdrop').removeClass('show');
    setTimeout(function(){
        $('.modal-backdrop').remove();
    }, 500);
}

function cancelDeleteModal() {
    sectionToDelete = null;
    $(deleteModal).removeClass('show');
    deleteBackdrop();
    setTimeout(function(){
        $(deleteModal).css({display: 'none'});
    }, 500);
}

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

    $(imageInputs).off('change');

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