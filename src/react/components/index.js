import React from 'react';
import Modules from './modules';
import Get from './crud/get';

const Index = () => {
    
    return (
        <div className="indexContent">
            <Hero />
            <Modules/>
        </div>       
    )
}

const Hero = () => {

    let data = {
        table: 'modules_content_sub',
        and: {
            'set': 'modules_content_id',
            'value': 14
        },
        column: ['name','class','link']
    };

    let getData = Get(data, '/public/php/crud/read.php');

    let newArr = [];
    let bubble = [];

    if (getData.length !== 0 && getData instanceof Array) {

        getData.map(obj => {

            if(obj.class == "button") {
                newArr.push(
                <React.Fragment key={obj.name}>
                    <a href={obj.link} className={obj.class}> {obj.name} </a>
                </React.Fragment>);
            }else{
                newArr.push(
                <React.Fragment key={obj.name}>
                    <h1 className={obj.class}> {obj.name} </h1>
                </React.Fragment>);
            }

        })
    }

    // bubble
	for(let x = 0; x <= 15; x++) {
	    bubble.push(
        <React.Fragment key={x}>
            <div className="bubbles"></div>
        </React.Fragment>);
	} 

    return ( 
        <section className = "container-fluid style hero">
            <header>
                 {newArr} 
            </header>
            
            {bubble}
        </section>
    );
}

export default Index;