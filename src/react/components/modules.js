import React from 'react';
import Get from './crud/get.js';

const Modules = () => {
    
    return (
        <>
            <Banner/>

        </>  
    );
}

const Banner = () => {

    let data = {
        type: 'banner'
    };

    let getData = Get(data, '/public/php/crud/read_modules.php');

    let newArr = [];

    if (getData.length !== 0 && getData instanceof Array) {
       
        getData.map(obj => {

            newArr.push(
                <React.Fragment key={obj.name}>
                    <h2>{obj.name}</h2>
                    <p>{obj.content}</p>
                </React.Fragment>
            );
        })
    }

    return (
        <div className="style indexBanner">
	        <div className="container m-center">
                {newArr}
	        </div>
        </div>
    );
}

const ProjectModule = () => {

    let data = {
        type: 'banner'
    };

    let getData = Get(data, '/public/php/crud/read_modules.php');

    let newArr = [];

    if (getData.length !== 0 && getData instanceof Array) {
       
        getData.map(obj => {

            newArr.push(
                <React.Fragment key={obj.name}>
                    <h2>{obj.name}</h2>
                    <p>{obj.content}</p>
                </React.Fragment>
            );
        })
    }

    return (
        <section className = "container-fluid project">
	        <header>
		        <h2>Kunskaper</h2>	
	        </header>

            <div div className = "container skills">
                {skills}
	        </div>
        </section>
    );
}

export default Modules;