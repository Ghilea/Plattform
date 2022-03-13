import React, {useEffect, useState} from 'react';

const GetProject = (data, link) => {

    const [error, setError] = useState(null);
    const [isLoaded, setIsLoaded] = useState(false);
    const [items, setItems] = useState([]);

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
        return <div>error: {error.message}</div>;
    }

    if(!isLoaded){
        return <div>Loading...</div>;
    }
    
    return items;

}

export default GetProject;