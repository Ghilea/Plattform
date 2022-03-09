import React, {useEffect, useState} from 'react';

const GetProject = (data, link) => {

    const [error, setError] = useState(null);
    const [isLoaded, setIsLoaded] = useState(false);
    const [items, setItems] = useState([]);
    let result;

    useEffect(() => {

        fetch(link, {
                method: 'POST',
                headers: {'Content-Type': 'application/json'},
                body: JSON.stringify(data)
            })
            .then(response => response.json())
            .then(data => {
                    setIsLoaded(true);
                    setItems(data);
                },
                (error) => {
                    setIsLoaded(true);
                    setError(error);
                })
    }, []);
    
    if(error){
        result = (<div>error: {error.message}</div>);
    }

    if(!isLoaded){
        result = (<div>Loading...</div>);
    }

    if (!error && isLoaded) {
        result =  items;
    }

    return result;
}

export default GetProject;