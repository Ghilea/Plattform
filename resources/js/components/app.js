import React, {useEffect, useState} from 'react';
import { BrowserRouter, Routes, Route } from "react-router-dom";
import Index from './index';
import ProjectView from './project';

const pages = [
    {component: Index},
    {component: ProjectView}
];

const App = () => {

    const [currentPageIndex, setCurrentPageIndex] = useState(0);

    useEffect(() => {
        setCurrentPageIndex(0);
    }, []) 

    const renderPage = () => {
        const Page = pages[currentPageIndex].component;
        return <Page />;
    }

    return (
        <React.Fragment>
            {renderPage()}
        </React.Fragment>
    )
}

export default App;