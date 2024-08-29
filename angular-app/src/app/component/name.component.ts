import { Component, OnInit } from '@angular/core'
import { RouterOutlet } from '@angular/router'

@Component(
    {
        standalone: true,
        selector: "app-name",
        imports: [
            RouterOutlet
        ],
        templateUrl: "./name.component.html"
    }
)
/*
export class NameComponent implements OnInit{
    constructor() {}
    ngOnInit(): void{

    }
}
*/



export class NameComponent {
    MyClick(){
        alert("srs");
    }
}