import { Component } from '@angular/core';
import { RouterOutlet, RouterModule } from '@angular/router';
import { NameComponent } from './component/name.component'

@Component({
  selector: 'app-root',
  standalone: true,
  imports: [
    RouterOutlet,
    NameComponent,
    RouterModule
  ],
  templateUrl: './app.component.html',
  styleUrl: './app.component.less'
})
export class AppComponent {
  title = 'angular-app';
}
