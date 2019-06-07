$(function(){

    $viewAddressBox = $("#view_address");
    $editAddressButton = $("#edit_data_button");
    $confirmAddressButton = $("#confirm_address");
    $selectedAddress = $viewAddressBox.find("input[name='selected_id']");
    $addresslistBox = $("#addresses_list");
    $addresses = $addresslistBox.find(".saved_address");
    $addAddressButton = $addresslistBox.find("#add_address");
    $editAddressBox = $("#edit_address");
    $newAddressButton = $editAddressBox.find("#save_address");


    $paymentBox = $("#payment");
    $paymentButtons = $paymentBox.find(".payment_element");

    $paypalButton = $paymentBox.find("#paga_paypal");
    $paypalForm = $paymentBox.find("#paypal_box>form");

    editAddress = function(){
        $viewAddressBox.hide();
        $addresslistBox.hide();
        $editAddressBox.show();
    }

    showAddressesList = function(){
        $viewAddressBox.hide();
        $addresslistBox.show();
    }

    changeAddress = function(e){
        var $newAddress = $(e.target).closest(".saved_address");
        var id = $newAddress.find("input[name='id']").val();
        if(id != $selectedAddress.val()){
            checkStoredAddress($newAddress, id);
        }else{
            $addresslistBox.hide();
            $viewAddressBox.show();
        }
    }

    checkStoredAddress = function($newAddress, id){
        $.ajax({
            url:"/api/address/"+id,
            method:"POST",
            dataType:"json",
            data: "cmd=check_id",
            error:function(req, text, error){
                ajax_error(req, text, error);
            }
        });
    }

    checkNewAddress = function(e){
        $.ajax({
            url:"/api/address/",
            method:"POST",
            dataType:"json",
            data: "cmd=check&"+$editAddressBox.find("input").serialize(),
            success:function(data){
                ajax_common(data);
                console.log(data);
                if(data.r = 200){
                    if(data.items.length === 0){
                        saveAddress();
                    }
                }
            },
            error:function(req, text, error){
                ajax_error(req, text, error);
            }
        });
    }

    saveAddress = function(){
        var nome = $editAddressBox.find("input[name='nome']").val();
        var cognome = $editAddressBox.find("input[name='cognome']").val();
        var comune = $editAddressBox.find("input[name='comune']").val();
        var via = $editAddressBox.find("input[name='via']").val();
        var civico = $editAddressBox.find("input[name='civico']").val();
        var note = $editAddressBox.find("input[name='note']").val();
        var telefono = $editAddressBox.find("input[name='telefono']").val();
        $viewAddressBox.find("#info_name").html(nome+" "+cognome);
        $viewAddressBox.find("#info_indirizzo").html(via+" "+civico+", "+comune);
        $viewAddressBox.find("#info_telefono").html(telefono);

        $editAddressBox.hide();
        $viewAddressBox.find(".actions").hide();
        $viewAddressBox.show();
        $paymentBox.slideDown();
    }

    confirmAddress = function(){
        $viewAddressBox.find(".actions").hide();
        $paymentBox.slideDown();
    }

    paymentButtonHandler = function(e){
        var $button = $(e.target).closest(".payment_element");
        $paymentBox.find(".payment_element.active").removeClass("active");
        $button.addClass("active");
        var box = $button.attr("data-box");
        $paymentBox.find(".payment_method").hide();
        $paymentBox.find(".payment_method#"+box).show();
    }

    paypalPaymentHandler = function(e){
        e.preventDefault();
        $.ajax({
            url:"/api/ordine/",
            method:"POST",
            dataType:"json",
            data: "type=PayPal&"+$viewAddressBox.find("input").serialize(),
            success:function(data){
                ajax_common(data);
                console.log(data);
                if(data.r = 200){
                    var $paypalBox = $paymentBox.find("#paypal_box");
                    $paypalBox.find("input[name='item_name']").val("ordine N&deg; "+data.order);
                    $paypalBox.find("input[name='custom']").val(data.order);
                    $paypalBox.find("input[name='return']").val(location.origin+"/spesa/end/"+data.order);
                    $paypalForm.submit();
                }
            },
            error:function(req, text, error){
                ajax_error(req, text, error);
            }
        });
    }

    $confirmAddressButton.click(confirmAddress);

    if(window.logged)
        $editAddressButton.click(showAddressesList);
    else
        $editAddressButton.click(editAddress);

    $addresses.click(changeAddress);
    $addAddressButton.click(editAddress);
    $newAddressButton.click(checkNewAddress);
    $paymentButtons.click(paymentButtonHandler);
    $paypalButton.click(paypalPaymentHandler);
})
