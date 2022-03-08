import React from 'react';
import Get from './get';

export default function ProjectView() {

    const urlParams = new URLSearchParams(window.location.search);
    const id = urlParams.get('id');

    let data = {
        single: true,
        id: id,
        table: 'project',
        column: ['title', 'content', 'link', 'link2', 'image', 'showBtn', 'created']
    };

    let dataSkillImages = {
        single: false,
        id: id,
        table: 'project_images',
        table2: '[<]project_skills',
        column: ['project_skills.name', 'project_skills.link']
    };

    let dataWorkFlow = {
        single: false,
        id: id,
        table: 'project_workflow',
        column: ['name', 'content', 'img']
    };

    let getData = Get(data);
    let getSkillImagesData = Get(dataSkillImages);
    let getWorkFlowData = Get(dataWorkFlow);

    return ( 
        <div className='container view'>
            <ProjectViewNav props={getData.title} />
            <ProjectViewHeader props={getData.title} />
            <ProjectViewHistory props={getData.content} />
            <ProjectViewBtn props={getData} />
            <ProjectViewSkills props={getSkillImagesData}/>
            <ProjectViewFrontImage props={getData} />
            <ProjectViewWorkFlow props={getWorkFlowData} />
        </div>
    )
}

const ProjectViewNav = (data) => {
    let title;

    if (data.props !== undefined) {
        title=data.props;
    }

    return (  
        <nav className = 'container row' key="navDataTitle">
            <a rel = "noreferrer noopener" href = "/index.php#project" title = "Gå tillbaka">Hem</a>
            <>-&gt;</>
            {title}   
        </nav>
    );
}

function ProjectViewHeader(data) {
    let title;

    if (data.props !== undefined) {
        title = data.props;
    }

    return (
        <header>
            <h1>{title}</h1>
        </header>
    );
}

function ProjectViewHistory(data) {
    let content;

    if (data.props !== undefined) {
        content = data.props;
    }

    return ( 
        <section aria-labelledby="background-title" className='container row'>
			<header>
				<h1 id="background-title">Bakgrundshistoria</h1>
			</header>
			<article>
				<p>{content}</p>
			</article>	
		</section>
    );
}

function ProjectViewBtn(data) {
    let link;
    let link2;

    if (data.props.link !== undefined || data.props.link2 !== undefined) {
        link = <a rel="noreferrer noopener" target="_blank" href={data.props.link} className="boxBtn">Live Demo</a>;

        link2 = <a rel="noreferrer noopener" target="_blank" href={data.props.link2} className="boxBtn">GitHub</a>;
    }

    return (
       <div className='container row'>
            {link}
            {link2}
        </div>
    );
}

function ProjectViewSkills(data) {

    let newArr = [];

    
    if (data.props.length !== 0 && data.props instanceof Array) {

        data.props.map(obj => {
            

            newArr.push( 
                <img src = {
                    obj.link
                }
                title = {
                    obj.name
                } 
                
                key = {
                    obj.name
                }
                
                />
            );
        });
    }

    return (
       <div className='toolImg'>{newArr}</div>
    );  
}

function ProjectViewFrontImage(data) {
    
    let title;
    let image;

    if (data.props.title !== undefined || data.props.image !== undefined) {
        title = data.props.title;
        image = data.props.image;
    }

    return (
       <section className='container row'>
			<figure>	
				<img src={image} title={title} alt={title} />
			</figure>
		</section>
    );
}

function ProjectViewWorkFlow(data) {

    let newArr = [];

    if (data.props.length !== 0 && data.props instanceof Array) {

        data.props.map(obj => {

        console.log(obj);

            newArr.push(
                <article key={obj.name}>
                    <p>{obj.content}</p>
                    <figure>
                        <img src={obj.img} alt={obj.name} />
                        <figcaption>
                            {obj.name}
                        </figcaption>
                    </figure>
			    </article>
            );
        });
    }

    return (
       <section className='workFlow'>
			{newArr}
		</section>
    );
}