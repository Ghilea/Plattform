import React, {useEffect, useState} from 'react';
import {BrowserRouter, Link} from "react-router-dom";
import Index from './index';
import ProjectView from './project';

const pages = [
    {component: Index},
    {component: ProjectView}
];

const App = () => {

    const [currentPageIndex, setCurrentPageIndex] = useState(0);

    useEffect(() => {
        //start with index page
        setCurrentPageIndex(0);
    }, []) 

    const renderPage = () => {
        const Page = pages[currentPageIndex].component;
        return <Page />;
    }

    return (
        <>
            {renderPage()}
            
            <BrowserRouter>
                <Link className="button" to="/modules/project/projectView.php?id=1" onClick={() => setCurrentPageIndex(1)}>Project</Link>
            </BrowserRouter>
        </>
    )
}

export default App;