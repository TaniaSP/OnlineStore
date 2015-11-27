<?php
include('correo\correo.php');
header("Content-Type: text/html;charset=utf-8");
class usuario{
    public $nombre;
    public $idusuario;
    public $apelldios;
    public $correo;
    public $fechaInscripcion;
    public $fechaNacimiento;
    public $contrasena;
    public $sexo;
    public $conexion;
    public $tipo;
    
    
    
    
    public function __construct ($conexion, $idusuario, $nombre, $apellidos, $correo, $fechaInscripcion, $fechaNacimiento, $contrasena, $sexo, $tipo){
        $this->idusuario = $idusuario;
        $this->conexion = $conexion;
        $this->nombre = $nombre;
        $this->apellidos = $apellidos;
        $this->correo = $correo;
        $this->fechaInscripcion = $fechaInscripcion;
        $this->fechaNacimiento = $fechaNacimiento;
        $this->sexo = $sexo;
        $this->contrasena = $contrasena;
        $this->tipo = $tipo;
    }
    
    public function buscaCodigo(){
        $consulta = mysql_query("SELECT codigoVerificacion".
                                " FROM correo". 
                                " where usuarios = '$this->idusuario' order by fecha desc;", $this->conexion);
        if ($registro = mysql_fetch_assoc($consulta)){
            return $registro['codigoVerificacion'];
        }
        else
        {
            return false;
        }
    }
    
    public function reporteUsuarios(){
        $consulta = mysql_query("SELECT count(*) as 'tipo' FROM usuario group by sexo, tipo;", $this->conexion);
        $valores=[];
        $i=0;
        while ($registro = mysql_fetch_assoc($consulta))
        {
            $valores[$i] = $registro['tipo'];
            $i++;
        }
        return $valores;
    }    
    public function reportePlayeras(){
        $consulta = mysql_query("SELECT clave, descripcion, marca, marcas.clave as claveMarca, color, precio, imagen FROM playeras, marcas where playera.marca = marcas.clave;", $conexion);
        $valores=[];
        $i=0;
        $html = "<table style='font-family:Calibri;'><tr><th>Id Playera</th>".
                "<th>Nombre</th>".
                "<th>Idd Marca</th>".
                "<th>Marca</th>".
                "<th>Color</th>".
                "<th>Precio</th>".
                "<th>Imagen</th></tr>";
        while ($resultado = mysql_fetch_assoc($consulta))
        {
            $html.="<tr><td>".$resultado['clave']."</td><td>"
                            .$resultado['descripcion']."</td><td>"
                            .$resultado['marca']."</td><td>"
                            .$resultado['claveMarca']."</td><td>"
                            .$resultado['color']."</td><td>"
                            .$resultado['precio']."</td><td>"
                            .$resultado['imagen']."</td></tr>";
        }
        include('mpdf57/mpdf.php');
        $html .= "</table>";
        $mpdf=new mPDF();
        $mpdf->allow_charset_conversion=true;  // Set by default to TRUE
        $mpdf->charset_in='iso-8859-1';
        $mpdf->WriteHTML($html);
        $mpdf->Output();
    
    }
    public function slider(){
        $consulta = mysql_query("Select descripcion from slider;", $this->conexion);
        $imagenes="";
        $i=0;
        while ($registro = mysql_fetch_assoc($consulta))
        {
            $imagenes[$i] = $registro['descripcion'];
            $i++;
        }
        return $imagenes;
    
    }
    
    public function cambioContra(){
        $consulta = mysql_query("SELECT nuevaContra FROM correo".
                                " WHERE usuarios = '$this->idusuario' order by fecha desc;", $this->conexion);
        if ($registro = mysql_fetch_assoc($consulta))
        {
            $nuevaContrasena = $registro['nuevaContra'];
            $this->contrasena = md5($this->nombre.$nuevaContrasena."%#M=");
            $resultado = mysql_query("UPDATE `usuario` SET `contra` = '$this->contrasena' WHERE `idusuario` = '$this->idusuario' AND `correo` = '$this->correo';", $this->conexion );
            if (!$resultado)
                die("<div id='resultado' >No se pudo realizar la modificacion".mysql_error()."<br /> <input type='button' value='Aceptar' onclick=\"this.parentNode.style.display = 'none'\"; /></div>");
            else
                echo "<div id='resultado' >Datos modificados exitosamente  <input type='button' value='Aceptar' onclick=\"this.parentNode.style.display = 'none'\"; /></div>";
            return true;
        }
        else
        {
            die("<div id='resultado' >No se pudo realizar la modificacion".mysql_error()."<br /> <input type='button' value='Aceptar' onclick=\"this.parentNode.style.display = 'none'\"; /></div>");
            return false;
        }
        
    }
        
    
     public function buscar()
    {
        $consulta = mysql_query("select * from usuario".
                                " where idusuario='".$this->idusuario."'"
                                ,$this->conexion);
        if ($registro = mysql_fetch_assoc($consulta))
        {
            $this->nombre=$registro['nombre'];
            $this->contrasena=$registro['contra'];
            $this->idusuario=$registro['idusuario'];
            $this->apellidos=$registro['apellidos'];
            $this->correo=$registro['correo'];
            $this->fechaInscripcion=$registro['fechInscripcion'];
            $this->fechaNacimiento=$registro['fechNacimiento'];
            $this->contrasena=$registro['contra'];
            $this->sexo=$registro['sexo'];
            $this->tipo=$registro['tipo'];
        }
        else
        {
            throw new Exception("no existe el usuario");
        }
    }
    
    public function esAdmin()
    {
        if ($this->tipo == "Admin")
            return true;
        else
            return false;
    }
    
    public function enviaCorreo($codigo, $nueva, $link)
    {
            $cuerpo= "Establecimiento de nueva contrase&ntilde;a al usuario <b>".$this->nombre.' '.$this->apellidos."</b><br />".
                    "Siga el siguiene enlace para continual con el cambio de contrase&ntilde;a:<br/> <a>".$link."</a></b>";
            $de = "tanytoon_money@hotmail.com";
            $asunto = "Cambio de contraseña";
            $cuerpo = wordwrap($cuerpo, 70);
            $fecha = new DateTime('2000-01-01', new DateTimeZone('America/Mazatlan'));
            $fecha =  $fecha->format('Y-m-d H:i:sP') . "\n";
            $datetime = new DateTime();
            $zona = new DateTimeZone('America/Mazatlan');
            $datetime->setTimezone($zona);
            $fecha =  $datetime->format('Y-m-d H:i:sP');
            $para = $this->correo;
            $correo = new correo($para, $cuerpo, $asunto);
            if  (!$correo->enviar())
            {
                return false;
            }
            $resultado =mysql_query("INSERT INTO `correo`(`usuarios`,`nuevaContra`,`codigoVerificacion`,`fecha`)".
                                    "VALUES ('$this->idusuario','$nueva','$codigo','$fecha')", $this->conexion);
            if (!$resultado){
                die("<div id='resultado' >No se pudo realizar la modificacion".mysql_error()."<br /> <input type='button' value='Aceptar' onclick=\"this.parentNode.style.display = 'none'\"; /></div>");
                return false;
            }
            return true;
    }
    
    public function acceso($pagina){
        $consulta = mysql_query("Select * from accesos, usuario where accesos.tipoUsuarios = usuario.tipo and nombre = '$this->nombre' and tipoUsuarios='$this->tipo' and pagina ='$pagina';", $this->conexion);
                                
        if ($registro = mysql_fetch_assoc($consulta))
        {
            return $registro['tipo'];
        }
        else
        {
            return false;
        }

    }
    
    
    public static function tablaUsuarios($conexion, $tipo){
        if ($tipo==0) $tipo = "Admin"; else $tipo="Cliente";
        $consulta = mysql_query("SELECT * FROM usuario where tipo = '$tipo';", $conexion);
        $i = 0;
        $tabla = [];
        while($registro = mysql_fetch_assoc($consulta)){
            $tabla[$i] = new usuario($conexion, $registro['idusuario'], $registro['nombre'], $registro['apellidos'], $registro['correo'], $registro['fechInscripcion'], $registro['fechNacimiento'], $registro['contra'], $registro['sexo'], $registro['tipo']);
            $i++;
        }
        return $tabla;
    }
    
    public function insertar(){	
        if ($this->tipo==0) $this->tipo = "Admin"; else $this->tipo="Cliente";
        if ($this->sexo==0) $this->sexo = "M"; else $this->sexo="F";
        $this->contrasena = 	md5($this->nombre.$this->contrasena."%#M=");
        $resultado =mysql_query("INSERT INTO `usuario` (`idusuario`, `nombre`,	`apellidos`, `correo`, `fechNacimiento`, `fechInscripcion`, `contra`, `sexo`, `tipo`) VALUES ('$this->idusuario', '$this->nombre','$this->apellidos','$this->correo','$this->fechaNacimiento','$this->fechaInscripcion','$this->contrasena', '$this->sexo', '$this->tipo');", $this->conexion);
        if (!$resultado)
            die("<div id='resultado' >No se pudo realizar la insercion".mysql_error()."<br /> <input type='button' value='Aceptar' onclick=\"this.parentNode.style.display = 'none'\"; /></div>");
        else
            echo "<div id='resultado' >Datos insertados exitosamente  <input type='button' value='Aceptar' onclick=\"this.parentNode.style.display = 'none'\"; /></div>";
    }
    public function modificar(){	
        if ($this->tipo==0) $this->tipo = "Admin"; else $this->tipo="Cliente";
        $this->contrasena = md5($this->nombre.$this->contrasena."%#M=");
        $resultado = mysql_query("UPDATE `usuario` SET `nombre` = '$this->nombre', `apellidos` = '$this->apellidos', `fechNacimiento` = '$this->fechaNacimiento', `fechInscripcion` = '$this->fechaInscripcion', `sexo` = '$this->sexo' , `tipo` = '$this->tipo' WHERE `idusuario` = '$this->idusuario' AND `correo` = '$this->correo';", $this->conexion );
        if (!$resultado)
            die("<div id='resultado' >No se pudo realizar la modificacion".mysql_error()."<br /> <input type='button' value='Aceptar' onclick=\"this.parentNode.style.display = 'none'\"; /></div>");
        else
            echo "<div id='resultado' >Datos modificados exitosamente  <input type='button' value='Aceptar' onclick=\"this.parentNode.style.display = 'none'\"; /></div>";
    }
    public function eliminar(){	
        $resultado = mysql_query("DELETE FROM `usuario` WHERE idusuario = '$this->idusuario';", $this->conexion );
        if (!$resultado)
            die("<div id='resultado' >No se pudo realizar la eliminacion".mysql_error()."<br /> <input type='button' value='Aceptar' onclick=\"this.parentNode.style.display = 'none'\"; /></div>");
        else
            echo "<div id='resultado' >Datos eliminados exitosamente  <input type='button' value='Aceptar' onclick=\"this.parentNode.style.display = 'none'\"; /></div>";
    }
    
    
}
?>