    <form class="form" action="" method="post" name="changePassword" onsubmit="return updatePassword();">
        <div class="form-floating">
            <input id="floatingChangeOldPassword" class="form-control" type="password" placeholder="Stara lozinka" name="oldPassword">
            <label for="floatingChangeOldPassword">Stara lozinka</label>
        </div>
        <div class="form-floating">
            <input id="floatingChangeNewPassword" class="form-control" type="password" placeholder="Nova lozinka" name="newPassword">
            <label for="floatingChangeNewPassword">Nova lozinka</label>
        </div>
        <div class="form-floating">
            <input id="floatingChangeNewPassword" class="form-control" type="password" placeholder="Ponovi lozinku" name="newPasswordRepeat">
            <label for="floatingChangeNewPassword">Ponovi lozinku</label>
        </div>
        <input class="btn btn-primary w-100" type="submit" value="Promeni lozinku" name="changePassword">
    </form>