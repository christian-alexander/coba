<div style='margin:1em 1em 1em 1em;'>
    <h3><b><p class="judul-profil"><?= $judul_tabel ?></p></b></h3>
    <table class="table table-striped"><?php
        foreach($data_tabel as $item){ ?>
            <tr>
                <td><?= $item[0] ?></td>
                <td><?= $item[1] ?></td>
            </tr><?php
        } ?>
    </table>
</div>
