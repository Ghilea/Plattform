import React from 'react';
import Get from './crud/get.js';

const Modules = () => {
    
    return (
        <Banner />
    );
}

const Banner = () => {
    
    let data = {
        table: 'modules_content',
        table2: {
            'table': '[<]modules',
            'id': '"modules_id'
        },
        column: ['modules_content.name', 'modules_content.content'],
        type: 'index',
        order: {
            'column': 'setOrder',
            'direction': 'ASC'
        }
    };
    
    let newArr = [];

    let getData = Get(data, '/resources/crud/read.php');

    if (getData.length !== 0 && getData instanceof Array) {
       
        console.log(getData);

        getData.map(obj => {

            newArr.push(
                <>
                    <h2>{obj.name}</h2>
                    <p>{obj.content}</p>
                </>
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

export default Modules;