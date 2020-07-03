<form id="send_email_form" method="POST">
    <h3>Želite da vas kontaktiramo?</h3>
    <p>Unesite vaše ime i kontakt telefon, kontaktirat ćemo vas u najkraćem roku. </p>



    <div class="form-group col-md-6 col-sm-6 col-xs-12">
        <label class="control-label col-md-6 col-sm-6 col-xs-12">Iznos(kn): </label>
        <div class="col-md-12 col-sm-12 col-xs-12">
            <input type="text" class="form-control" name="valuesLoan" value="<?php echo $_GET['ValuesLoan']?>"/>
        </div>
    </div>
    <div class="form-group col-md-6 col-sm-6 col-xs-12">
        <label class="control-label col-md-6 col-sm-6 col-xs-12">Mjeseci: </label>
        <div class="col-md-12 col-sm-12 col-xs-12">
            <input type="text" class="form-control" name="valuesMonths" value="<?php echo $_GET['ValuesMonths']?>"/>
        </div>
    </div>

    <div class="form-group">
        <label class="control-label col-md-6 col-sm-6 col-xs-12">Vaše ime: </label>
        <div class="col-md-12 col-sm-12 col-xs-12">
            <input type="text" class="form-control" id="client-name" name="clientName" value=""/>
        </div>
    </div>
    <div class="form-group">

        <label class="control-label col-md-6 col-sm-6 col-xs-12">Telefon: </label>
        <div class="col-md-12 col-sm-12 col-xs-12">
            <input type="text" class="form-control" id="client-phone" name="clientPhone" value="" required/>
        </div>
    </div>
    <div class="form-group">
        <label class="control-label col-md-6 col-sm-6 col-xs-12">Poruka:</label>
        <div class="col-md-12 col-sm-12 col-xs-12">
            <textarea id="client-note" class="resizable_textarea form-control" form="send_email_form"></textarea>
        </div>
    </div>
    <input type="hidden" class="form-control" id="client-web" name="clientWeb" value=""/>
</form>

