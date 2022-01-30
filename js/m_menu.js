let menuIds = ['m_home','m_social','m_discourse','m_matrix','m_mail','m_stats','m_avatar'];

function setMenuItem(id) {
	menuIds.forEach((item, index) => {
		document.getElementById(item).className = "nav-link";
	});
	document.getElementById(id).className = "nav-link active";
	console.log("setting menu item");
}
