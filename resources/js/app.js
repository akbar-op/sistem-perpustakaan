const darkModeToggle = document.querySelector('#dark-mode-toggle');
const darkModeStorageKey = 'perpusku-dark-mode';

const setDarkMode = (enabled) => {
	document.documentElement.classList.toggle('dark', enabled);

	if (darkModeToggle) {
		darkModeToggle.checked = enabled;
		darkModeToggle.setAttribute('aria-checked', String(enabled));
	}
};

const savedDarkMode = localStorage.getItem(darkModeStorageKey) === 'true';
setDarkMode(savedDarkMode);

darkModeToggle?.addEventListener('change', (event) => {
	const enabled = event.currentTarget.checked;
	localStorage.setItem(darkModeStorageKey, String(enabled));
	setDarkMode(enabled);
});
