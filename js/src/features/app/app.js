import { useStoreon } from '@storeon/solidjs';
import { createState } from 'solid-js';

import List from '../list/list';

import { StyledTitle, StyledParagraph, StyledContainer } from './app.styled';

const App = () => {

    return (
        <StyledContainer>
            <StyledTitle>RAWB Search Dashboard</StyledTitle>
            <StyledParagraph>This lets you control and reindex each index in the search service</StyledParagraph>
            <StyledParagraph>Indexes:</StyledParagraph>
            <List />
        </StyledContainer>
    );

};

export default App;

