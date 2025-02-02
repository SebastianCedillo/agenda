import { Component, OnInit } from '@angular/core';
import { NavController } from '@ionic/angular';
import { AccesoService } from '../servicio/acceso.service';


@Component({
  selector: 'app-menu',
  templateUrl: './menu.page.html',
  styleUrls: ['./menu.page.scss'],
  standalone:false,
})
export class MenuPage implements OnInit {

  nombre:string="";
  contactos:any=[];
  cod_persona:string="";

  constructor(
    private navCtrl:NavController,
    private servicio:AccesoService
  ) {
    this.servicio.getSession('persona').then((res:any)=>{
      this.nombre=res;
    });

    this.servicio.getSession('idpersona').then((res:any)=>{
      this.cod_persona=res;
      this.lcontactos();
    });

    
   }

  ngOnInit() {
  }

  lcontactos(){
    let datos = {
      "accion":"lcontactos",
      "codigo":this.cod_persona
    }
    this.servicio.postData(datos).subscribe((res:any)=>{
      if(res.estado){
        this.contactos=res.data;

      }else{
        this.servicio.showToast(res.mensaje,2000);
      }
    });
  }

  nuevo(){
    this.navCtrl.navigateRoot(['contacto']);
  }

  irEditar(cod_contacto:string){
    this.navCtrl.navigateRoot(['acontacto']);
    this.servicio.createSession('cod_contacto',cod_contacto);
  }

  irEliminar(cod_contacto:string){
    this.navCtrl.navigateRoot(['econtacto']);
    this.servicio.createSession('cod_contacto',cod_contacto);

  }

}
