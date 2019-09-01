import React, {Component} from "react";

export const SectionTitle  = ({title="Section Title"})=>{
    return (
        <header className="pl-3">
            <h1>{title}</h1>
        </header>
    );
};
