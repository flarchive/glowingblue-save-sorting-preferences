import app from 'flarum/forum/app';
import replaceSortDropdown from './extenders/replaceSortDropdown';

app.initializers.add('glowingblue-save-sorting-preferences', () => {
	replaceSortDropdown();
});
