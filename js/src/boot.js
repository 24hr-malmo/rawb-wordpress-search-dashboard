import { render } from 'solid-js/dom';
import { StoreonProvider } from '@storeon/solidjs';

import store from './store';
import App from './features/app/app';
import { AppProvider } from './context/app-context.jsx';

const getData = (id) => {
    try {
        return JSON.parse(document.getElementById(id).innerHTML); // eslint-disable-line
    } catch (err) {
        console.log('error', id, err); // eslint-disable-line
        return {};
    }
};


window.addEventListener('load', () => {
    const appState = getData('rawb-search-dashboard-appstate');
    render(() => {
        return (
            <StoreonProvider store={store(appState)}>
                <AppProvider appState={appState}>
                    <App/>
                </AppProvider>
            </StoreonProvider>
        );
    }, document.getElementById('rawb-search-dashboard-page-root'));
});
