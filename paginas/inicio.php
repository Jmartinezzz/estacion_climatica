<?php 
	require_once('conexion/conexion.php');
	$conexion = conectar();
	if (isset($_POST['fecha'])) {
		$fechaa = $_POST['fecha'];
		$fechatratada = date_format(date_create($fechaa),'d-M-Y');
		$sql = "select * from temperaturasdiarias WHERE Date_format(HoraRegistro,'%Y-%m-%d') = '$fechaa' ";
	}else{
		$sql = "select * from temperaturasdiarias";
	}	
	$resultado = mysqli_query($conexion, $sql);
?>
<style>
	table {
        width: 100%;
    }

thead, tbody, tr, td, th { display: block; }

tr:after {
    content: ' ';
    display: block;
    visibility: hidden;
    clear: both;
}

tbody {
    height: 400px;
    overflow-y: auto;
}

tbody td, thead th {
    width: 32%;
    float: left;
}
</style>
<div class="container mt-5 pt-3">
	<h1>Registro de temperaturas</h1>	
	<div class="row mt-3">
		<div class="col-md-7">
			<table class="table table-hover table-">
    			<thead>
				    <tr>
				    	<th>ID</th>
						<th>Temperatura °C</th>
						<th>Fecha / hora</th>		      
				    </tr>
				</thead>
			    <tbody>			    	
			    	<?php if(mysqli_num_rows($resultado) < 1): 
			       		echo "<tr><td class='col-12 text-center'>No hay registro de temperaturas</td></tr>";
			       	else:			       
					while($temp = mysqli_fetch_array($resultado)):?>			       
					<?php
						$fecha = date_format(date_create($temp['HoraRegistro']), 'd-M-Y h:i A');
					?>
			        <tr>
			        	<td><?= $temp['ID']; ?></td>
			        	<td>&nbsp;&nbsp;&nbsp;&nbsp;<?= $temp['Temperatura']; ?></td>			        	
			        	<td><?= $fecha; ?></td>
			        </tr>
					<?php
					 
					 endwhile;
					 endif; 				
					mysqli_close($conexion);			
					?>
			    </tbody>
			</table>
		</div>		
		<div class="col-md-5">
			<div class="row">
				<div class="col-md-6">
					<form action="" method="POST" id="formFecha">
						<div class="form-group">						
								<label for="fecha">Buscar por fecha:</label>
								<input type="date" class="form-control btn-outline-primary" id="fecha" name="fecha">
							<p class="small"><?php if(isset($fechaa)) echo "Fecha busqueda:  " . $fechatratada; ?></p>							
						</div>
					</form>
				</div>
				<div class="w-100"></div>
				<div class="col-md-12 border">
					<h4>Datos de interes:</h4>
					<div id="seccion"></div>
				</div>
			</div>
		</div>
	</div>
</div>
<script>
	$('#fecha').on('change', function(e){
		
		$('#formFecha').submit();
	})
</script>