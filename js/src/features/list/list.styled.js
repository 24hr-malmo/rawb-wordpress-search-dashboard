import { styled } from 'solid-styled-components';

export const Container = styled('div')`
     color: black;
`;

export const StyledIndexItem = styled('div')`
    font-size: 14px;
    display: flex;
    align-items: center;
    margin-top: .5rem;
`;

export const StyledIndexLabel = styled('div')`
    width: 200px;
    padding-right: 2rem;
`;

export const StyledReindexButton = styled('div')`
    font-size: 14px;
    color: white;
    padding: .5rem 2rem .4rem;
    text-align: center;
    background-color: #2196f3;
    cursor: pointer;
    border-radius: 2px;
    display: flex;
    align-items: center;
    position: relative;
`;

export const StyledReindexButtonText = styled('div')`
    padding: .1rem 0;
`;

export const StyledLoadingContainer = styled('div')`
    position: absolute;
    top: 8px;
    right: 8px;
`;
