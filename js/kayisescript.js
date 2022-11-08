jQuery(document).ready(function () {
    var i = 1;
    var x = 1;
    jQuery('#add').click(function () {
        i++;
        jQuery('#serviceTable').append('<tr id="row' + i +
            '"><td><input type="file" name="service_iconUpload[]" id="service_icon"></td><td><input type="text" name="brand[]" placeholder="Enter your Name" class="form-control name_list" /></td><td><button type="button" name="remove" id="' +
            i + '" class="btn btn-danger btn_remove">X</button></td></tr>');
    });
    jQuery('.addcarfield').click(function () {
        var row = jQuery(this).data("row");
        x++;
        jQuery('#subfield' + row).append('<li class="list-group-item" id="row' + x + '"><div class="row"><div class="col-9"><div class="row"><div class="col-6"><input type="file" name="carBrand[]" id="banner' + row + '"></div><div class="col-6"><input type="text" name="car_name[]" placeholder="Enter your Name" class="form-control name_list" /></div></div></div><div class="col-3"><button type="button" name="remove" id="' + x + '" class="btn btn-danger btn_remove">X</button></div></div></li>');
    });
    jQuery(document).on('click', '.btn_remove', function () {
        var button_id = jQuery(this).attr("id");
        jQuery('#row' + button_id + '').remove();
    });
    jQuery(".dltServBtn").on("click", '.dltServBtn', function (e) {
        e.preventDefault();
        alert();
    });
    jQuery(document).on("click", '.delSubSer', function (e) {
        e.preventDefault();
        var servID = jQuery(this).data('sid');

        //document.getElementById("thefunc" + servID).value = "delete_brand";
        if (confirm("Are you sure?!") == true) {

            //document.getElementById("form" + servID).submit();
            jQuery.ajax({
                url: ajaxurl,
                method: "POST",
                data: {
                    'action': "delete_car",
                    'bid': servID,
                },
                success: function (data) {
                    console.log(data);
                },
                error: function (jqXHR, exception) {
                    var msg = '';
                    if (jqXHR.status === 0) {
                        msg = 'Not connect.\n Verify Network.';
                    } else if (jqXHR.status == 404) {
                        msg = 'Requested page not found. [404]';
                    } else if (jqXHR.status == 500) {
                        msg = 'Internal Server Error [500].';
                    } else if (exception === 'parsererror') {
                        msg = 'Requested JSON parse failed.';
                    } else if (exception === 'timeout') {
                        msg = 'Time out error.';
                    } else if (exception === 'abort') {
                        msg = 'Ajax request aborted.';
                    } else {
                        msg = 'Uncaught Error.\n' + jqXHR.responseText;
                    }
                    jQuery('#post').html(msg);
                },
            });
        } else {
            text = "You canceled!";
            alert(text);
        }
    });
    jQuery('.btn_updates').click(function () {
        var servID = jQuery(this).data('sid');
        alert(servID);
        //document.getElementById("thefunc" + servID).value = "update_brand";
        document.getElementById("form" + servID).submit();
        /* jQuery.ajax({
    url: "<?php echo admin_url('admin-ajax.php'); ?>",
method: "POST",
data: {
    'action': "update_brand",
'bid': jQuery(this).attr("id"),
'destinationName': jQuery("#subname" + jQuery(this).attr("id")).val(),
'destinationDesc': jQuery("#subdesc" + jQuery(this).attr("id")).val(),
            },
success: function(data) {
    alert(data);

            }
        }); */
    });



});

jQuery(".dltServBtn").on("click", '.dltServBtn', function (e) {
    e.preventDefault();
    alert();
});
/* Bind fuction deletService to each btn with class dltServBtn */
var deleteBtns = document.getElementsByClassName("dltServBtn");

for (var x = 0; x < deleteBtns.length; x++) {

    var result = confirm("Want to delete?");
    if (result) {
        //Logic to delete the item
        deleteBtns[x].addEventListener("click", deleteService);
    }

}

function deleteService(e) {
    e.preventDefault();
    var servID = jQuery(this).data('sid');

    document.getElementById("thefunc" + servID).value = "delete_brand";
    var icon = jQuery(this).attr('id');
    if (confirm("Are you sure?!") == true) {

        document.getElementById("form" + servID).submit();



        /*         jQuery.ajax({
        url: "<?php echo admin_url('admin-ajax.php'); ?>",
    method: "POST",
    data: {
        'action': "delete_brand",
    'bid': servID,
    'icon': icon,
                    },
    success: function(data) {
        alert(data);
                    }
                }); */
    } else {
        text = "You canceled!";
    }
}
function readURL(input) {

    if (input.files && input.files[0]) {
        var reader = new FileReader();
        reader.onload = function (e) {
            const img = document.getElementById(jQuery(input).data('target'));
            img.setAttribute('src', '');
            img.setAttribute('src', e.target.result);
        }
        reader.readAsDataURL(input.files[0]);
    }
}