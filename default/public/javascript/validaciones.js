
/*********************************************
*                                            *
*           SECCION DE VALIDACIONES          *
*                                            *   
*                                            *
*********************************************/
   function valideKey(evt) //solo numeros
    {
        var code = (evt.which) ? evt.which : evt.keyCode;
        if(code==8)
        {
            //backspace
            return true;
        }
        else if(code>=48 && code<=57)
        {
            //es numerp
            return true;
        }
        else
        {
            return false;
        }
    }
    
    
        function valideKey2(evt) //solo letras
    {
        var code = (evt.which) ? evt.which : evt.keyCode;
        if(code==8)
        {
            //backspace
            return true;
        }
        else if((code>=65 && code<=90)||(code>=97 && code<=122))  
        {
            //letra mayuscula y minuscula
            return true;
        }
        else if(code==32){
            //espacio
            return true;
        }
        else        
            //return false;
            if((code==241)||(code==209)||(code==220)||(code==252)||(code==164)||(code==165)||(code==154)||(code==129))
            {
                
               return true; 
            }
            else {
              //alert(code);
                return false;}
    }

 
function largoDni2(num,id){ //controla el largo del dni....
    var dni= document.getElementById(""+id.id+"");// trae el id del elemento donde va a aparecer el error
    var doc = document.getElementById(""+num+"");
 if(doc.value.length == 8){
   dni.innerHTML='';
    return true;
 }
 else{
     //alert('El dni debe tener 8 digitos');
     dni.style.color="red";
     dni.innerHTML='El dni debe tener 8 digitos';
//     matriculado_dni.focus();
//     ExisteDni.focus();
    doc.focus();

     return false;
 }
 
}


function validarEmail2(email,idmail) {
	var cod; 
        var correo = document.getElementById(""+idmail.id+"");// obtiene el id del elemtto donde aparecera el msj de error
        correo.style.color="red";
        
        
        expr = /^([a-zA-Z0-9_\.\-])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+$/;
	yahoo =/yahoo/;
        hotmail=/hotmail/;
        gmail=/gmail/;
        outlook=/outlook/;
        
        // codificacion de los dominios
	if ( yahoo.test(email) ){
	  cod=1;
	}
        if ( hotmail.test(email) ){
	  cod=2;
	}
        if ( gmail.test(email) ){
	  cod=3;
	}
        if ( outlook.test(email) ){
	  cod=4;
	}
        
        //control de formato de e-mail (xxx@xxx.xxx)
    if ( !expr.test(email) ){
        correo.innerHTML="Error: La dirección de correo [" + email + "] es incorrecta";
        
		return false;
		}
		
	switch(cod)	{
		case 1:{
			    yahoo=/yahoo.com.ar/;
                            if(!yahoo.test(email)){
                                correo.innerHTML="yahoo invalido";
                                return false;
                            }
                            else{
                                correo.innerHTML="";
                                return true;}
                            ; break;
		       }
                case 2:{
                         hot=/hotmail.com/;
                         hot2=/hotmail.com.ar/;
                         if((!hot.test(email)&&(!hot2.test(email)))){
                             correo.innerHTML="hotmail invalido";
                             return false;
                         }
                         else{
                             correo.innerHTML="";
                             return true;}
                         ;break;
                       }
                case 3:{
                        gmail=/gmail.com/;
                        if(!gmail.test(email)){
                            correo.innerHTML="Gmail invalido";
                            return false;
                        } 
                        else{
                            correo.innerHTML="";
                            return true;}
                        break;
                }
                       default: {
                               correo.innerHTML="";
                               return true;}
	}
		
}

function CuilH(dni,cuil1)//calcula el cuil de Hombres
{
    if(matriculado_dni.value.length == 8)
    {
        var doc= document.getElementById(""+dni.id+"");
        var inpcuil= document.getElementById(""+cuil1.id+"");
        var com = [20];
        var vec = [5,4,3,2,7,6,5,4,3,2];
        var total = 0;
        var cuil;
        docum = doc.value;
        com= ""+com+docum;
        for (var i=0;i < vec.length; i++)
        {
            total += parseInt(com[i])*vec[i];
        }

        var mod = total % 11;
        if (mod == 0)
        {
            cuil=com+"0";
        }
        else
        {
            if (mod ==1)
            {
              cuil = "23"+doc.value+"9";  
            }
            else
            {
                var Z = 11-mod;
                cuil= ""+com+Z;
            }
        }
        inpcuil.value= cuil;  
    }
    else
    {
        matriculado_dni.focus();
        matriculado_sexo0.checked=false;
    }
}

function CuilM(dni,cuil1) //calcula el cuil Mujeres
  { 
      if(matriculado_dni.value.length == 8)
      {
          var doc= document.getElementById(""+dni.id+"");
          var inpcuil= document.getElementById(""+cuil1.id+"");
          var com = [27];
          var vec = [5,4,3,2,7,6,5,4,3,2];
          var total = 0;
          var cuil;            
              docum = doc.value;
              com= ""+com+docum;
              for (var i=0;i < vec.length; i++)
              {
                  total += parseInt(com[i])*vec[i];
              }

              var mod = total % 11;
              if (mod == 0)
              {
                  cuil=com+"0";
              }
              else
              {
                  if (mod ==1)
                  {
                    cuil = "23"+doc.value+"4";  
                  }
                  else
                  {
                      var Z = 11-mod;
                      cuil= ""+com+Z;
                  }
              }
              inpcuil.value= cuil; 
      }
      else
      {
          matriculado_dni.focus();
          matriculado_sexo1.checked=false;
      }

  }
  
/*
 * Funcion mascara, da el formato de fecha (inserta los "-" en la cadena)
 */
function mascara(dat)
{
   var pat= [2,2,4];
   var d = document.getElementById(""+dat+"");
   var val2=[];
   var val3= [];
  if(d.valant != d.value)
  { 
   val = d.value;
   largo = val.length;
   val = val.split("-");
   
   for(r=0;r<val.length;r++)
   {
       val2 += val[r];
   }
   
   val='';
   val3=[];
   for(s=0;s<pat.length;s++)
   {
       val3[s]= val2.substring(0,pat[s]);
       val2=val2.substr(pat[s]);
   }
   
   for(q=0;q<val3.length;q++)
   {
       if(q==0)
       {
           val = val3[q];
       }
       else
       {
           if(val3[q] !="")
           {
               val += "-"+val3[q];
           }
       }
   }
   
   
   d.value= val;
   d.valant= val;
  }
}  

/*
 * Funcion CtrlDia: controla el ingreso del dia
 */

function CtrlDia(dia,largo,valor,anio) 
{
  if(largo == 0) //si el largo de la fecha es 0 entonces permite ingresar (0 , 1 , 2 o 3)
    {
        if(dia < 52)
        {
            return true;
        } 
        else return false;
    }

    if (largo == 1)            //si el largo de la fecha es uno y el valor es 0 permite ingresar valores del 1 al 9
    {
        if (valor == 0)
        {
            if(dia > 48)
            {
                return true;
            }
            else{return false;}
        }
        else
        {
            if(valor == 3)      //si el largo de la fecha es uno y el valor es 3 permite ingresar valores del 0 al 1
            {
                if(dia < 50)
                {
                    return true;
                }
                else return false;
            }

            else return true;   //si el largo de la fecha es uno y el valor es distinto de 0 y de 3 permite ingresar valores del 0 al 9
        }
    }
    if(largo > 1){return CtrlMes(dia,largo,valor,anio);}
  
}


function CtrlMes(mes,largo,valor,anio) //controla en ingreso del mes
{
    var sub = valor.substr(3,1); //extrae primer dijito del mes
    var sub2 = valor.substr(0,2); // extrae el nro del dia
    if(largo == 2)      //Controla el primer dijito del mes
    {
        if(mes < 50) // permite ingresa solo 0 o 1(compara con el ascii)
        {
            return true;
        }
        else return false;
    }
    if(largo == 4) // controla el segundo dijito del mes
    {
       if(sub == 1)// si el prime dijito del mes es 1 permite ingresar 0, 1 o 2
       {
           if(sub2 == 31) //Si el dia ingresado es 31 permite ingresar meses 10 y 12
           {
               switch(mes)
               {
                   case 48: return true;break;
                   case 50: return true;break;
                   default: return false;
               }
           }
           else
           {
               switch(mes) //sino permite ingresar meses 10, 11 , 12
               {
                   case 48: return true;break;
                   case 49: return true;break;
                   case 50: return true;break;
                   default: return false;
                           
               }
           }
       } 
       
       if(sub == 0) //si el prime dijito del mes es 0 permite ingresar 1, 2, 3, 4, 5, 6, 7, 8, 9
       {
           if (sub2 == 31) //Si el dia ingresado es 31 permite ingresar meses 1, 3, 5, 7, 8
           {
               switch(mes)
               {
                   case 49: return true;break;
                   case 51: return true;break;
                   case 53: return true;break;
                   case 55: return true;break;
                   case 56: return true;break;
                   default:return false; break;
               }
           }
           else
           {
               if(sub2 == 30) //Si el dia ingresado es 30 no permite el ingreso del 0 ni del 2
               {
                   switch(mes)
                   {
                       case 48: return false;break;
                       case 50: return false;break;
                       default: return true; break;
                   }
               }
               else
               {
                 return true;   
               }
           }

       }
    }
    else return CtrlAño(mes,largo,valor,anio);
}

function CtrlAño(año,largo,valor,anio)
{  
    var a= ""+anio;
    var subm = a.substr(0,1);    //extrate la unidad de mil del año tomado del servido
    var subc = a.substr(1,1);    //extrae la centena del año tomado del servidor
    var subd = a.substr(2,1);    //extrae la decena del año tomado del servidor
    var subu = a.substr(3,1);    //extrae la unidad del año tomado del servidor
    
    if(largo == 5) //control del ingreso del primer dijito del año
    {
        if((año > 48) && (año < 49+ parseInt(subm))) // Controla que el primer dijito del año sea menor o igual al primer
        {                                            // dijito del año sacado de la fecha del servidor.
           return true;
        }
        else return false;
    } 
    
    if (largo == 7)  //control del ingreso del segundo dijito del año
    {
        var mil= valor.substr(6,1);
        if(mil == subm)
        {
            if (año < 49+parseInt(subc))
            {
                return true;
            }
            else return false;
        }
        else return true;
        
    }
    if (largo == 8) //contro del ingreso del tercer dijito del año
    {
        var cen = valor.substr(7,1);
        if(cen == subc)
        {
            if(año < 49+parseInt(subd))
            {
                return true;
            }
            else return false;
        }
        else return true;
    }
    
    if (largo == 9) //Control del ingreso del cuarto dijito del año
    {
        var dec = valor.substr(8,1);
        if (dec == subd)
        {
            if (año < 49+parseInt(subu))
            {
                return true;
            }
            else return false;
        }
        else return true;
    }
}

   function SoloNumFec(evt,id,anio) //solo numeros para las fechas
    {
        var fec = document.getElementById(""+id+"");
        var largo = fec.value.length;
        var code = (evt.which) ? evt.which : evt.keyCode;
        if(code==8)
        {
            //backspace
            return true;
        }
        else if(code>=48 && code<=57)
        {
            //es numerp
            if(CtrlDia(code,largo,fec.value,anio)) 
            {
                return true;
            }
            else return false;
            
        }
        else
        {
            return false;
        }
    }
    
    function Largofec(id,error) // controla la fecha completa
    {
        var fec = document.getElementById(""+id+"");
        var msj = document.getElementById(""+error.id+"");
        var lar = fec.value.length;
        if (lar != 10)
        {
            msj.style.color="red";
            msj.innerHTML= "La fecha ingresada es incorrecta";
            fec.focus();
        }
        else
        {
            msj.innerHTML = "";           
        }
    }



function mayus()// Convierte a mayusculas los valores de los inputs ingresados en el formulario de registro de profesionales
{
    var nombre = matriculado_nombre.value;
    var apellido = matriculado_apellido.value;
    var lnac = matriculado_lugnac.value;
    var nac = matriculado_nacionalidad.value;
    var mail = matriculado_mail.value;
    var instform= mataux_instform.value;
    var titulo= mataux_titulo.value;
    
   matriculado_nombre.value = nombre.toUpperCase();
   matriculado_apellido.value = apellido.toUpperCase();
   matriculado_lugnac.value = lnac.toUpperCase();
   matriculado_nacionalidad.value = nac.toUpperCase();
   matriculado_mail.value = mail.toLowerCase();
   mataux_instform.value = instform.toUpperCase();
   mataux_titulo.value = titulo.toUpperCase();
}

function mayus2()// Convierte a mayusculas los valores de los inputs en el formulario de profesional ya registrado
{
	var titulo = mataux_titulo.value;
	var instform = mataux_instform.value;
	mataux_titulo.value = titulo.toUpperCase();
	mataux_instform.value = instform.toUpperCase();
	
}

function mayustram()//convierte a mayusculas los valores de los inputs ingresados en la solicitud de tramite
{
	var ape = tramite_apellido.value;
	var nom = tramite_nombre.value;
	var mail = tramite_mail.value;
	var matricula = tramite_matricula.value;
	
	tramite_apellido.value = ape.toUpperCase();
	tramite_nombre.value = nom.toUpperCase();
	tramite_mail.value = mail.toLowerCase();
	tramite_matricula.value = matricula.toUpperCase(); 
}

function CtrlarDni(id)//Controla el largo del DNI en la vista Verificar.phtml
{
    dni = document.getElementById(''+id.id+'');
    if(dni.value.length!=8)
    {
        return false;
    }
    else
    {
        return true;
    }
    
}

/*********************************************
*                                            *
*       SECCION DE MENSAJES AL USUARIO       *
*                                            *   
*                                            *
*********************************************/

function Mosprof(idprof) // musestra el mensaje de profecionales 
{
    var prof = document.getElementById(''+idprof.id+'');
    prof.style.color='blue';
    prof.innerHTML='Denominacion genérica que se utiliza para referirse a una \n\
            profesión o a un conjunto que se asocian a una misma actividad';
}

function Ocuprof(idprof) // oculta el mensaje de profecionales
{
   var prof = document.getElementById(''+idprof.id+'');
   prof.innerHTML='';
}

function Mosfectit(idfec) //muestra el mensaje de la fecha de obtencion del titulo
{
    var fec = document.getElementById(''+idfec.id+'');
    fec.style.color='blue';
    fec.innerHTML='Fecha de obtención de Título';
}

function Ocufectit(idfec)// oculta el mensaje de la fecha de obtencion del titulo
{
    var fec = document.getElementById(''+idfec.id+'');
    fec.innerHTML='';
}

function FecAyu(id)// muestra yuda de la fecha
{
    var fec = document.getElementById(""+id.id+"");
    fec.style.color = "blue";
    fec.innerHTML="ej: 01-08-1990";
}

function FecAyu1(id) // oculta ayuda de la fecha
{
    var fec = document.getElementById(""+id.id+"");
    fec.innerHTML="";
}

function MostObj(id) // muestra un elemento html oculto
{
	var obj = document.getElementById(''+id.id+'');
	obj.style.display='block';
}
    




/*********************************************
*                                            *
*           SECCION DE CONTROL DEL           *
*            FORMULARIO                      *   
*                                            *
*********************************************/


function NoReval(iddiv){// si no posee revalida oculta el campo de revalida
    div = document.getElementById(""+iddiv.id+"");
    div.style.display= 'none';
   
}

function SiReval(iddiv){ // si posee revalida muestra el campo de revalida
    div = document.getElementById(''+iddiv.id+'');
    div.style.display = 'block';
}

function CtrlCheck(idcheck,idinp)
{
    var check = document.getElementById(''+idcheck+'');
    var inp = document.getElementById(''+idinp.id+'');
    
    if (check.checked){
        //inp.innerHTML = '';
        inp.style.display= "block";
        mataux_codif_id.style.display = "none";
    }
    else
    {
        //inp.innerHTML = '';
        inp.style.display= "none";
        mataux_codif_id.style.display='inline';
    }
}

    
    function confirmar()//Muestra un mesaje de confirmacion con todos los datos del registro
    {
       var dni = matriculado_dni.value;
       var nombre = matriculado_nombre.value;
       var apellido = matriculado_apellido.value;
       var fnac = matriculado_fnac.value;
       var lnac = matriculado_lugnac.value;
       var nac = matriculado_nacionalidad.value;
       var sexo;
       var mail = matriculado_mail.value;
       var cuil = matriculado_cuil.value;
        if(confirm("Sus datos son:\nDni: "+dni+"\nNombre: "+nombre+"\nApellido: "+apellido+"\nFecha de nacimiento: "+fnac
                +"\nLugar de nacimiento: "+lnac+"\nE-mail: "+mail+"\n\nSus datos son correctos?"))
        {
           return true;
        }
        else
        {
           return false;
        }
    }
    
    function cambiarvalor(id1,id2,id3)// setea el select a la opcion de inicio
    {
       var check = document.getElementById(""+id1+"");
       var select = document.getElementById(""+id2.id+"");
       var inp = document.getElementById(""+id3.id+"");
       
       if (check.checked)
       {
           select.selectedIndex = 0;
          
       }
       else
       {
           inp.value= null;
       }
    }
    
    function Filtro(id) //Pasa el valor de un selec a la accion del controlador
    {
      var select = document.getElementById(""+id+"");
        window.location="/turnos/matriculado/filtro1/"+select.value;
    }
    
    function VentanaEmer1()
    {
        window.open("/turnos/matriculado/filtro1/0", "", "width=500,height=300");
    }
    
    function imprimir(btn1, btn2 , div)
    {
        boton1= document.getElementById(""+btn1.id+"");
        boton2= document.getElementById(""+btn2.id+"");
		div1 = document.getElementById(""+div.id+"");
        
        boton1.style.display = 'none';
        boton2.style.display = 'none';
		div1.style.display = 'block';
        
        window.print();
        
        boton1.style.display = 'block';
        boton2.style.display = 'block';
		div1.style.display = 'none';
        return true;
    }