import React from 'react';

export default function GetProject(data){
    const [error, setError] = React.useState(null);
    const [isLoaded, setIsLoaded] = React.useState(false);
    const [items, setItems] = React.useState([]);
    let result;

    React.useEffect(() => {

        fetch('./skills.php', {
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