import { Component } from '@angular/core';
import { AccesoService } from '../servicio/acceso.service';
import { ModalController, NavController } from '@ionic/angular';
import { CuentaPage } from '../cuenta/cuenta.page';




@Component({
  selector: 'app-home',
  templateUrl: 'home.page.html',
  styleUrls: ['home.page.scss'],
  standalone: false,
})
export class HomePage {
  txt_usuario:string="";
  txt_clave:string="";



  constructor(
    private servicio:AccesoService,
    private navCtrl:NavController,
    private modalCtrl:ModalController,
    
  ) {}

  login(){
  
  let datos={
    accion:'login',
    usuario:this.txt_usuario,
    clave:this.txt_clave
  }
  this.servicio.postData(datos).subscribe((res:any)=>{
    if(res.estado){
      this.servicio.createSession('idpersona',res.persona.codigo);
      this.servicio.createSession('persona',res.persona.nombre);

      this.navCtrl.navigateRoot(['/menu']);
    }else{
      this.servicio.showToast("No existe persona",3000);
    }
  })

  }

 async crear(){
    const modal = await this.modalCtrl.create({
      component:CuentaPage
    });
    return await modal.present();
  }

  recuperar(){

  }


}
