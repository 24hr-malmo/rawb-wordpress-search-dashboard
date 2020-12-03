import { styled } from 'solid-styled-components';

export const Button = styled('button')`
     background-color: #8bc34a;
     color: white;
     font-weight: bold;
     border: none;
     border-radius: 5px;
     padding: 10px;
     margin-right: 10px;
     margin-top: 10px;
     width: 100%;
     border: 3px solid #4caf50;
     outline: none;
     &:hover {
        background-color: #009688;
        cursor: pointer;
     }
`;

export const ButtonList = styled('div')`
     display: grid;
     grid-auto-columns: auto;
     grid-auto-flow: column;
     grid-column-gap: 10px;
`;


