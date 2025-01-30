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

  constructor(
    private navCtrl:NavController,
    private servicio:AccesoService
  ) {
    this.servicio.getSession('persona').then((res:any)=>{
      this.nombre=res;
    });
   }

  ngOnInit() {
  }

}
