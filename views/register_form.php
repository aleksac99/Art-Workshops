<form action="" enctype="multipart/form-data" method="post" name="register" class="form address-search-form" onsubmit="return <?php echo $validation; ?>;">
    <div class="form-floating">
        <input required id="floatingFirstName" class="form-control" type="text" placeholder name="firstName" value="<?php echo ($u ?? false) ? $u->getFirstName() : '';?>">
        <label for="floatingFirstName">Ime</label>
    </div>
    <div class="form-floating">
        <input required id="floatingLastName" class="form-control" type="text" placeholder name="lastName"  value="<?php echo ($u ?? false) ? $u->getLastName() : '';?>">
        <label for="floatingLastName">Prezime</label>
    </div>
    <div class="form-floating">
        <input required id="floatingUsername" class="form-control" type="text" placeholder='Korisničko ime' name="username"  value="<?php echo ($u ?? false) ? $u->getUsername() : '';?>" <?php if ($u??false) echo "disabled=true";?>>
        <label for="floatingUsername">Korisničko ime</label>
    </div>
<?php
if (!($u ?? false)) { ?>
    <div class="form-floating">
        <input required id="floatingPassword" class="form-control" type="password" placeholder='Lozinka' name="password">
        <label for="floatingPassword">Lozinka</label>
    </div>
    <div class="form-floating">
        <input required id="floatingRepeat" class="form-control" type="password" placeholder='Ponovi lozinku' name="repeatPassword">
        <label for="floatingRepeat">Ponovi lozinku</label>
    </div>
<?php } ?>
    <div class="form-floating">
        <input required id="floatingPhone" class="form-control" type="text" placeholder='Kontakt telefon' name="phoneNumber"  value="<?php echo ($u ?? false) ? $u->getPhoneNumber() : '';?>" pattern="^06\d{1,8}$" title="Broj počinje sa 06 i sadrži najviše 10 cifara">
        <label for="floatingPhone">Kontakt telefon</label>
    </div>
    <div class="form-floating">
        <input required id="floatingEmail" class="form-control" type="email" placeholder='E-mail adresa' name="email"  value="<?php echo ($u ?? false) ? $u->getEmail() : '';?>" <?php if ($u??false) echo "disabled=true";?>>
        <label for="floatingEmail">E-mail adresa</label>
    </div>
<?php if (!($u ?? false)) { ?>
    <div class="form-group p-2">
        <p>Izaberi profilnu sliku</p>
        <input class="form-control" type="file" id="profile-picture" name="profilePicture">
    </div>
    <div class="form-check p-2">
    <input type="checkbox" class="form-check-input" name="asOrganizer" id="as-organizer" onchange="ToggleOrganizerInputs()">
        <label class="form-check-label" for="as-organizer">Registruj se kao organizator</label>
    </div>
    <div class="form-floating">
        <input id="floatingOrgName" class="form-control" type="text" placeholder="Naziv organizacije" disabled="disabled" name="organizationName">
        <label for="floatingOrgName">Ime organizacije</label>
    </div>
    <div class="form-floating">
        <input id="floatingAddress" class="address-search form-control" type="text" size=50 placeholder="Adresa" disabled="disabled" name="organizationAddress">
        <label for="floatingAddress">Adresa</label>
    </div>
    <div class="address-search-result" style="position: absolute; z-index:2; background: white;"></div>
    <div class="form-floating">
        <input id="floatingOrgNumber" class="form-control" type="text" placeholder="Matični broj" disabled="disabled" name="organizationNumber"pattern="^\d{10}$" title="Broj mora imati tačno 10 cifara">
        <label for="floatingOrgNumber">Matični broj organizacije</label>
    </div>
    <div class="form-group m-4">
        <input class="btn btn-primary w-100" type="submit" value="Registruj se">
    </div>
<?php } else {?>
    <div class="form-group m-4">
    <input class="btn btn-primary w-100" type="submit" value="Izmeni podatke" name="updateProfile">
    </div>
<?php } ?>
</form>
