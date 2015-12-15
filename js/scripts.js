function seguroconn($cod,$con){
//var con = document.getElementById('cod_con').value;
confirmar=confirm("¿Seguro que quieres eliminar el concepto \"" + $con + "\"?"); 
    if (confirmar) {
        // si pulsamos en aceptar
        alert('El concepto será eliminado.');
        window.location='inc/delete_con.php?cod_con='+$cod;
        return true;
    }else{ 
        // si pulsamos en cancelar
        return false;
    }           
}

function seguroconce($con){
confirmar=confirm("¿Seguro que quiere eliminar el concepto: " + $con + "?"); 
    if (confirmar) {
        // si pulsamos en aceptar
        alert('El concepto será eliminado.');
        window.location='inc/delete_conce.php?concepto='+$con;
        return true;
    }else{ 
        // si pulsamos en cancelar
        return false;
    }
}

function segurocli($cif){
//var con = document.getElementById('cif').value;
confirmar=confirm("¿Seguro que desea eliminar el cliente con el CIF \"" + $cif + "\"?"); 
	if (confirmar) {
		// si pulsamos en aceptar
		alert('El cliente será eliminado.');
		window.location='inc/delete_cliente.php?cif='+$cif;
		return true;
	}else{ 
		// si pulsamos en cancelar
		return false;
	}			
}

function changeCli(obj) {
    var selectBox = obj;
    var selected = selectBox.options[selectBox.selectedIndex].value;
    var sele = selected.split("|");
    var textarea = document.getElementById("cliente1");
    var text = document.getElementById("cif1");

    if(sele[0] === "1"){
        textarea.style.display = "block";
        text.style.display = "none";
    }else if (sele[0] === ""){
        textarea.style.display = "none";
        text.style.display = "none";
    }else{
        textarea.style.display = "none";
        text.style.display = "block";
    }
    document.getElementById("cif1").value = sele[1];
}

function changeCliman(obj) {
    var selectBox = obj;
    var selected = selectBox.options[selectBox.selectedIndex].value;
    var textarea = document.getElementById("cliente1");
    var text = document.getElementById("cif1");

    if(selected === "1"){
        textarea.style.display = "block";
        text.style.display = "none";
    }else if (selected === ""){
        textarea.style.display = "none";
        text.style.display = "none";
    }else{
        textarea.style.display = "none";
        text.style.display = "block";
    }
    document.getElementById("cif1").value = selected;
}

function changeClim(obj,ver) {
    var selectBox = obj;
    var version = ver;
    var selected = selectBox.options[selectBox.selectedIndex].value;
    var sele = selected.split("|");
    var textarea = document.getElementById("cliente1"+version);
    var text = document.getElementById("cif1"+version);

    if(sele[0] === "1"){
        textarea.style.display = "block";
        text.style.display = "none";
    }else if (sele[0] === ""){
        textarea.style.display = "none";
        text.style.display = "none";
    }else{
        textarea.style.display = "none";
        text.style.display = "block";
    }
    document.getElementById("cif1"+version).value = sele[1];
}

function changeConIndem(obj,ver) {
    var selectBox = obj;
    var version = ver;
    var selected = selectBox.options[selectBox.selectedIndex].value;
    var textarea = document.getElementById("text_area"+version);

    if(selected === "1"){
        textarea.style.display = "block";
    }
    else{
        textarea.style.display = "none";
    }
} 

function changeCon(obj,nue) {
    var selectBox = obj;
    var nue = nue;
    var selected = selectBox.options[selectBox.selectedIndex].value;
    var sele = selected.split("|");
    var textarea = document.getElementById("text_area"+nue);

    if(sele[0] === "1"){
        textarea.style.display = "block";
    }
    else{
        textarea.style.display = "none";
    }
    document.getElementById("precio"+nue).value = sele[1];
}

function seguroConFac($con,$fac,$ord){
    //var con = document.getElementById('cod_con').value;
    confirmar=confirm("¿Seguro que desea eliminar el concepto \"" + $con + "\" de la factura \"" + $fac + "\"?");
    if (confirmar) {
        // si pulsamos en aceptar
        alert('El concepto será eliminado.');
        window.location='inc/delete_con_fac.php?concepto='+$con+'&cod_fac='+$fac+'&orden='+$ord;
        return true;
    }else{ 
        // si pulsamos en cancelar
        return false;
    }           
}

function changeNumPan(obj,num,pan) {
    var selectBox = obj;
    var num = num;
    var pan = pan;
    var selected = selectBox.options[selectBox.selectedIndex].value;
    var sele = selected.split("|");
    var textarea = document.getElementById("text_area"+num);

    if(sele[0] === "1"){
        textarea.style.display = "block";
        document.getElementById("precio"+num).value = pan;
    }
    else{
        textarea.style.display = "none";
        document.getElementById("precio"+num).value = sele[1];
    }
}

function changeConInde(obj) {
    var selectBox = obj;
    var selected = selectBox.options[selectBox.selectedIndex].value;
    var textarea = document.getElementById("text_area");

    if(selected === "1"){
        textarea.style.display = "block";
    }
    else{
        textarea.style.display = "none";
    }
} 

function seguroFac($cod_fac){
//var con = document.getElementById('cod_fac').value;
confirmar=confirm("¿Seguro que quiere eliminar la factura con el código \"" + $cod_fac + "\"?"); 
    if (confirmar) {
        // si pulsamos en aceptar
        alert('La factura será eliminada.');
        window.location='inc/delete_factura.php?cod_fac='+$cod_fac;
        return true;
    }else{ 
        // si pulsamos en cancelar
        return false;
    }           
}