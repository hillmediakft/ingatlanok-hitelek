<div class="modal-header">
	<button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
	<h4 class="modal-title">Részletek</h4>
</div>
<div class="modal-body">		
	<dl class="dl-horizontal">
	
	
		<dt style="font-size:100%; color:grey;">Azonosító szám:</dt>
		<dd>#<?php echo $content['id'];?></dd>
		<div style="border-top:1px solid #E5E5E5; margin: 8px 0px;"></div>

		<dt style="font-size:100%; color:grey;">Hirdetés címe:</dt>
		<dd><?php echo $content['ingatlan_nev'];?></dd>
		<div style="border-top:1px solid #E5E5E5; margin: 8px 0px;"></div>

		<dt style="font-size:100%; color:grey;">Leírás:</dt>
		<dd><?php echo $content['leiras'];?></dd>
		<div style="border-top:1px solid #E5E5E5; margin: 8px 0px;"></div>

		<dt style="font-size:100%; color:grey;">Hirdetés címe angolul:</dt>
		<dd><?php echo $content['ingatlan_nev_en'];?></dd>
		<div style="border-top:1px solid #E5E5E5; margin: 8px 0px;"></div>

		<dt style="font-size:100%; color:grey;">Leírás angol:</dt>
		<dd><?php echo $content['leiras_en'];?></dd>
		<div style="border-top:1px solid #E5E5E5; margin: 8px 0px;"></div>

		<dt style="font-size:100%; color:grey;">Cím:</dt>
		<dd><?php echo $content['iranyitoszam'] . ' Budapest, ' . $content['district_name'] . ' kerület, ' . preg_replace('~\s([0-9]+)\-([0-9]+)\.~', '', $content['street_name']) . ' ' . $content['hazszam'] . '.'; ?></dd>
		<div style="border-top:1px solid #E5E5E5; margin: 8px 0px;"></div>


		
		<dt style="font-size:100%; color:grey;">Jellemzők:</dt>
		<?php echo (empty($content['allatbarat'])) ? '' : '<dd>Állatbarát</dd>';?>
		<?php echo (empty($content['gyerekbarat'])) ? '' : '<dd>Gyerekbarát</dd>';?>
		<dd></dd>
		<div style="border-top:1px solid #E5E5E5; margin: 8px 0px;"></div>


		
		
		
		<dt style="font-size:100%; color:grey;">Létrehozás dátuma:</dt>
		<dd><?php echo date('Y-m-d H:i', $content['hozzaadas_datum']);?></dd>
		<div style="border-top:1px solid #E5E5E5; margin: 8px 0px;"></div>

		<dt style="font-size:100%; color:grey;">Módosítás dátuma:</dt>
		<dd><?php echo (empty($content['modositas_datum'])) ? ' - ' : date('Y-m-d H:i', $content['modositas_datum']);?></dd>
		<div style="border-top:1px solid #E5E5E5; margin: 8px 0px;"></div>
		
		
		<dt style="font-size:100%; color:grey;">Státusz:</dt>
		<dd><span class="label label-sm label-danger"><?php echo ($content['status'] == 0) ? 'Inaktív' : 'Aktív';?></span></dd>

	</dl>	
</div>	 
<div class="modal-footer">
	<button onclick="window.location.href = 'admin/property/update/<?php echo $content['id'];?>';" type="button" class="btn blue">Adatok módosítása</button>
	<button type="button" class="btn default" data-dismiss="modal">Bezár</button>
</div>