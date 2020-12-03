import { createStoreon } from 'storeon';

let indexes = store => {

    store.on('@init', () => ({indexes:[]}));

    store.on('indexes/set', ({ }, indexes) => {
        return { indexes };
    });

    store.on('indexes/reindexing', ({ indexes }, name) => {
        const index = indexes.find(index => index.name === name);
        if (index) {
            index.status = 'reindexing';
        }
        return { indexes: [...indexes] };
    });

    store.on('indexes/reindexing-done', ({ indexes }, name) => {
        const index = indexes.find(index => index.name === name);
        if (index) {
            index.status = 'idle';
        }
        return { indexes: [...indexes] };
    });

};

const createStore = (initialState) => {
    const store = createStoreon([indexes]);
    store.dispatch('indexes/set', initialState.indexes || []);
    return store;
};

export default createStore;

