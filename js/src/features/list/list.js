import { useStoreon } from '@storeon/solidjs';
import { useContext} from 'solid-js';

import { AppContext } from '../../context/app-context.jsx';
import Loading from '../../components/loading/loading';
import { post } from '../../utilities/wp-action';

import { 
    StyledIndexLabel, 
    StyledIndexItem, 
    StyledReindexButton, 
    StyledReindexButtonText, 
    StyledLoadingContainer,
    Container ,
} from './list.styled';

const List = () => {

    const [state, { indexes }] = useContext(AppContext);

    const reindex = async (name) => {
        indexes.reindex(name);
        await post('rawb-search-dashboard-reindex', { name });
        indexes.reindexDone(name);
    };

    return (
        <Container>
            { state.indexes.list.map(index => (
                <StyledIndexItem>
                    <StyledIndexLabel>{index.name}</StyledIndexLabel>
                    <StyledReindexButton onClick={() => reindex(index.name)}>
                        <StyledReindexButtonText>Re-index</StyledReindexButtonText>
                        { index.status === 'reindexing' && <StyledLoadingContainer><Loading /></StyledLoadingContainer> }
                    </StyledReindexButton>
                </StyledIndexItem>
            )) }
        </Container>
    );

};

export default List;

