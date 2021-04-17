<!-- TABEL DATA FULL EDITABLE JANGAN UBAH APA2 ATAU KACAUUU SEMUA NANTI -->


<div class = "div-tabel" id="<?= $config['id_tabel']?>" style="<?= $config['default_display'] ?>">
    <h3><p class="judul-tabel"><?= $config['judul_tabel'] ?></p></h3>
    <table class="table table-striped">  
        <thead>  
            <tr><?php
            	foreach($arr_head as $item){ 
                    if($item[1] == TRUE){ ?>
                    	<th> 					  <?= $item[0] ?> </th><?php
                    }else if($item[1] == FALSE){ ?>  
            			<th class='onphone-hide'> <?= $item[0] ?> </th><?php
                    } 
                } ?>
                <th> <?= $head_clickable ?> </th>
            </tr>  
        </thead>  
        <tbody><?php
            foreach($data as $item){ 
                if($is_lama_magang){
                    $kolom_lama_magang = str_replace("~",'',$kolom_lama_magang);
                    $bulan = $item[$kolom_lama_magang];
                    if($bulan >= 9 && $bulan < 11){
                        echo "<tr style = 'background-color:rgb(235, 223, 114);'>";
                    }else if($bulan >= 11){
                        echo "<tr style = 'background-color:rgb(219, 141, 141);'>";
                    }else{
                        echo "<tr>";
                    }
                } ?>
                <!-- disini merender isi2 yang diperlukan untuk td nya -->
                <?php
                	foreach($arr_item as $item2){ 
                        $kolom_value = str_replace("~",'',$item2[0]);
                        $value = $item[$kolom_value];
                        if($item2[1] == TRUE){ ?>
                        	<td> 					  <?= $value ?> </td> <?php
                        }else if($item2[1] == FALSE){ ?>
                			<td class='onphone-hide'> <?= $value ?> </td> <?php
                        } 
                    } ?>
                    <!-- disini suda td button2 action -->
                    <td style="white-space:nowrap;"> 
                        <div class='btn-group'> <?php
                        	foreach($arr_clickable as $item2){ 
                                if($item2['id'] !== NULL && $item2['confirm_func'] != NULL && $item2['confirm_msg'] != NULL){
                                    $kolom_id = str_replace('~','',$item2['id']);
                                    $id = $item[$kolom_id]; 
                                    $class = $item2['class']; ?> 
                                    <form method="POST" action="<?= $item2['href'] ?>" onsubmit ="return <?= $item2['confirm_func'] ?>()">  
                                    <span><a href="#" class="<?= $item2['jenis_icon'] ?>" title="<?= $item2['toggle'] ?>" data-toggle="tooltip"><button type="submit" style="background:rgba(0,0,0,0);color:inherit;border:0px solid white;" id="<?= $id ?>" class="<?= $class ?>"><i class="material-icons"><?= $item2['jenis_icon'] ?></i></button></a></span> 
                                    <?php
                                }else{
                                    $class = $item2['class']; ?> 
                                	<form method="POST" action="<?= $item2['href'] ?>">
                                    <span><a href="#" class="<?= $item2['jenis_icon'] ?>" title="<?= $item2['toggle'] ?>" data-toggle="tooltip"><button type="submit" style="background:rgba(0,0,0,0);color:inherit;border:0px solid white;" class="<?= $class ?>"><i class="material-icons"><?= $item2['jenis_icon'] ?></i></button></a></span> 
                                    <?php
                                }
                                    //penting untuk menggunakan === atau !== bila membandingkan tipe data, karena seperti kasus strpos ini dia bisa return boolean atau int
                                        //nah sebelumnya pakai != tidak bisa setelah diganti !== bisa
                                        if(strpos($item2['db_clicked'],'~') !== FALSE){
                                            $kolom_db_clickable = str_replace("~",'',$item2['db_clicked']); 
                                            $db_clickable = $item[$kolom_db_clickable];
                                        }else{
                                            $db_clickable = $item2['db_clicked'];
                                        } ?>
                                        <input type="text" name="db" value="<?= $db_clickable ?>" style="display:none;">
                                        
                                        <?php
                                        $kolom_id_clickable = str_replace("~",'',$item2['id_clicked']);
                                        $id_clickable = $item[$kolom_id_clickable]; 
                                        ?>
                                        <input type="text" name="id" value="<?= $id_clickable ?>" style="display:none;">
                                    </form> <?php
                            } ?>
                            <div class='dropdown'>
                                <a href='#' aria-haspopup="true" aria-expanded="false" class='ondesktop-hide' title="Info" data-toggle="dropdown"><button type="submit" style="background:rgba(0,0,0,0);color:inherit;border:0px solid white;"><i class="material-icons">info</i></button></a>
                                <div class='dropdown-menu'> <?php
                                    $i = 0;
                                    foreach($arr_item as $item2){
                                        $kolom_value = str_replace("~",'',$item2[0]);
                                        $value = $item[$kolom_value]; 
                                        if($item2[1] == FALSE){ ?>
                                            <a class='dropdown-item'> <?= $arr_head[$i][0] ?> : <?= $value ?></a> <?php
                                        }
                                        $i++;
                                    } ?>
                                </div>
                            </div>
                        </div>
                    </td>
                </tr><?php
            } ?>
        </tbody>
    </table>
</div> 


<!-- loading bar -->
<div id = 'bg-for-loading'>
    <div id = 'lds-dual-ring'></div>
</div>

<script>
    $(document).ready(function(){
        $('table.table').dataTable();
    });

    /*untuk setiap tipe tombol yang memerlukan konfirmasi akan dibuat fungsi ini*/
	<?php
    foreach($arr_clickable as $item){ 
        if($item['confirm_func'] != null && $item['confirm_msg'] != null){ ?>
    		$('.<?= $item['class'] ?>').click(function <?= $item['confirm_func'] ?>(object){
                var msg_awal = '<?= $item['confirm_msg'] ?>';
                var msg = msg_awal.replace("-id",this.id);
                if(confirm(msg)){
                    $('#bg-for-loading').css('display','block');
                    $('#lds-dual-ring').css('display','inline-block');
                    return true;
                }else{
                    return false;
                }
            }); <?php
        }
    } ?>

        
</script>