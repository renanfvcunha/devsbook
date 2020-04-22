<?= $render('header', ['user' => $loggedUser]) ?>
<section class="container main">
    <?= $render('sidebar', ['activeMenu' => 'settings']) ?>
    <div class="feed mt-10 settings">
        <h1>Configurações</h1>
        <form id="updateProfile">
            <hr/>
            <div class="flashArea">
                <div class="flashMsg"></div>
            </div>
            <span class="red">*</span> Obrigatório<br/><br/>
            <label>
                Nome Completo: <span class="red">*</span><br/>
                <input type="text" name="name" value="<?= $loggedUser->name ?>">
            </label><br/><br/>
            <label>
                Data de Nascimento: <span class="red">*</span><br/>
                <input id="birthdate" type="text" name="birthdate" value="<?= $loggedUser->birthdate ?>">
            </label><br/><br/>
            <label>
                E-mail: <span class="red">*</span><br/>
                <input type="text" name="email" value="<?= $loggedUser->email ?>">
            </label><br/><br/>
            <label>
                Cidade:<br/>
                <input type="text" name="city" value="<?= $loggedUser->city ?>">
            </label><br/><br/>
            <label>
                Trabalho:<br/>
                <input type="text" name="work" value="<?= $loggedUser->work ?>">
            </label><br/><br/>
            <hr/>
            <label>
                Nova Senha:<br/>
                <input type="password" name="password">
            </label><br/><br/>
            <label>
                Confirmar Senha:<br/>
                <input type="password" name="confPassword">
            </label><br/><br/>
            <button class="button" type="submit">Salvar</button>
        </form>
    </div>
</section>
<?= $render('footer') ?>