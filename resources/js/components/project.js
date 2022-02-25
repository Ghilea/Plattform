import React from 'react';
import Get from './get';

export default function ProjectView() {
/* <ProjectViewNav />
            <ProjectViewHeader />
            <ProjectViewHistory />
            <ProjectViewBtn />*/
    return ( 
        <div className='container view'>
           
            <ProjectViewSkills />
            <ProjectViewFrontImage />
            <ProjectViewWorkFlow />
        </div>
    )
}

function ProjectViewNav() {
    let data = {
        id: 1,
        table: 'project',
        column: ['title', 'content', 'link', 'link2', 'image', 'showBtn', 'created']
    };

    let getData = Get(data);

    return (  
        <nav className = 'container row'>
            <a rel = "noreferrer noopener" href = "/index.php#project" title = "Gå tillbaka">Hem</a>
            <>-&gt;</>
            {getData.title}
        </nav>
    );
}

function ProjectViewHeader() {
    let data = {
        id: 1,
        table: 'project',
        column: ['title', 'content', 'link', 'link2', 'image', 'showBtn', 'created']
    };

    let getData = Get(data);
    
    return (
        <header>
            <h1>{getData.title}</h1>
        </header>
    );
}

function ProjectViewHistory() {
    let data = {
        id: 1,
        table: 'project',
        column: ['title', 'content', 'link', 'link2', 'image', 'showBtn', 'created']
    };

    let getData = Get(data);

    return ( 
        <section aria-labelledby="background-title" className='container row'>
			<header>
				<h1 id="background-title">Bakgrundshistoria</h1>
			</header>
			<article>
				<p>{getData.content}</p>
			</article>	
		</section>
    );
}

function ProjectViewBtn() {
    let data = {
        id: 1,
        table: 'project',
        column: ['title', 'content', 'link', 'link2', 'image', 'showBtn', 'created']
    };

    let getData = Get(data);

    let link;
    let link2;

    if (getData.link !== null) {
        link = <a rel="noreferrer noopener" target="_blank" href={getData.link} className="boxBtn">Live Demo</a>;
    }

    if (getData.link2 !== null) {
        link2 = <a rel="noreferrer noopener" target="_blank" href={getData.link2} className="boxBtn">GitHub</a>;
    }

    return (
       <div className='container row'>
            {link}
            {link2}
        </div>
    );
}

function ProjectViewSkills() {
    let data = {
        table: 'project_skills',
        column: ['name', 'link']
    };

    let getData = Get(data);
    
    return (
       <div className='toolImg'>
            {getData.map((item) => {
                <img src="data:image/png;base64,R0lGODlhAQABAAD/ACwAAAAAAQABAAACADs=" data-src={item.link} title={item.name} alt="blabla" key={item.link} />
        })}
		</div>
    );  
}

function ProjectViewFrontImage() {
    let data = {
        id: 1,
        table: 'project',
        column: ['title', 'content', 'link', 'link2', 'image', 'showBtn', 'created']
    };

    let getData = Get(data);

    return (
       <section className='container row'>
			<figure>	
				<img src="data:image/png;base64,R0lGODlhAQABAAD/ACwAAAAAAQABAAACADs=" data-src={getData.image} title={getData.title} alt="" />
			</figure>
		</section>
    );
}

function ProjectViewWorkFlow() {
    let data = {
        id: 1,
        table: 'project',
        column: ['title', 'content', 'link', 'link2', 'image', 'showBtn', 'created']
    };

    let getData = Get(data);

    return (
       <section className='workFlow'>
			
			<article>
				<p>{getData.content}</p>
				<figure>
					<img src={getData.image} alt="" />
					<figcaption>
						{getData.title}
					</figcaption>
				</figure>
			</article>
		
		</section>
    );
}