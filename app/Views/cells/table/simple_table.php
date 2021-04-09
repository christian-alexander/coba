<div class="container">
    <div class = "row"><?php
        foreach($tables as $item){ ?>
            <div class = "col" style="margin-bottom:3em;">
                <h3><b><p class="judul-profil"><?= $item[0] ?></p></b></h3>
                <table class="table table-striped"><?php
                    foreach($item[1] as $data){ ?>
                        <tr>
                            <td><?= $data[0] ?></td>
                            <td><?= $data[1] ?></td>
                        </tr><?php
                    } ?>
                </table>
            </div> <?php
        } ?>       
    </div>
</div>
