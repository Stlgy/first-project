<header>
    <div id="clock" onload="currentTime();"></div><!--clock-->
    <div class="transpText">
        <div class="tit1"> My Favorite League of Legends Champions </div>
    </div>
    <div id="forms">
        <div class="loginRegs">
            <?php
            //login2($msgLog);
            $l = new Login;
            $l->login2();
            ?>
        </div>
        <div class="pesqCaixa">
            <form class="pesq" action="res_pesquisa.php" method="GET">


                <!--formulario de pesquisa-
                <input type="text" name="fpesq" required>
                <input type="submit" value="Pesquisar">-->


                <input type="pesq" name="fpesq"  pattern=".*\S.*" required>
                <button class="pesq-btn" value="" type="submit"><span></span></button>
            </form>
        </div>
    </div>
</header>