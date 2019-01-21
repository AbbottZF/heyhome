/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * 通用表单提交(AJAX方式)
 */
(function() {
  'use strict';
  window.addEventListener('load', function() {
    // Fetch all the forms we want to apply custom Bootstrap validation styles to
    var forms = document.getElementsByClassName('needs-validation');
    console.log(forms);
    // Loop over them and prevent submission
    var validation = Array.prototype.filter.call(forms, function(form) {
      form.addEventListener('submit', function(event) {
        if (form.checkValidity() === false) {
          event.preventDefault();
          event.stopPropagation();
        }else{
            event.preventDefault();
            event.stopPropagation();
            setTimeout(function () {
                $.ajax({
                    url: form.action,
                    type: form.method,
                    data: $(form).serialize(),
                    success: function (res) {
                        closeLoading();
                        showAlert(res.msg);
                        if (res.code === 1) {
                            setTimeout(function () {
                                window.location.replace(res.url);
                            }, 2000);
                        }
                    },
                    error:function(){
                        closeLoading();
                        showAlert('网络错误,请重试');
                    }
                });
            }, 300)
        }
        form.classList.add('was-validated');
      }, false);
    });
  }, false);
})();

$("form").on('submit(*)', function (data) {
    console.log('44444');
    showLoading('提交中...');
    setTimeout(function () {
        $.ajax({
            url: data.form.action,
            type: data.form.method,
            data: $(data.form).serialize(),
            success: function (res) {
                closeLoading();
                showAlert(res.msg);
                if (res.code === 1) {
                    setTimeout(function () {
                        window.location.replace(res.url);
                    }, 2000);
                }
            },
            error:function(){
                closeLoading();
                showAlert('网络错误,请重试');
            }
        });
    }, 300)
    return false;
});
/**
 * 加载中
 * @returns {undefined}
 */
function showLoading(msg){
    if(!msg){
        msg = '加载中...';
    }
    var html = '';
    html += '<div class="modal-dialog" role="document">';
    html += '<div class="modal-content">';
    html += '<div class="modal-body">';
    html += '<span>'+msg+'</span>';
    html += '</div>';
    html += '</div>';
    html += '</div>';
    $('#body_model').empty().append(html).modal('show');
}
/**
 * 关闭加载层
 * @returns {undefined}
 */
function closeLoading(){
    $('#body_model').empty().modal('hide');
}
/**
 * 打开提示框
 * @param {type} msg
 * @returns {undefined}
 */
function showAlert(msg,html){
    if(!html){
        var html = '';
        html += '<div id="body-alert" class="alert alert-dismissible alert-primary">';
        html += msg;
        html += '<button type="button" class="close" data-dismiss="alert" aria-label="Close">';
        html += '<span aria-hidden="true">&times;</span>';
        html += '</button>';
        html += '</div>';
    }
    $("#body_top").empty().append(html);
    setTimeout(function () {
        closeAlert();
    }, 2000);
}
/**
 * 关闭提示框
 * @returns {undefined}
 */
function closeAlert(){
    $("#body-alert").alert('close');
}