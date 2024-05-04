/**
 * Function to open the navigation sidebar
 */
function openNav() {
  // Get the sidebar and set its width
  document.getElementById("mySidebar").style.width = "250px";

  // Adjust the main content's margin to accommodate the sidebar
  document.getElementById("main-content").style.marginLeft = "250px";
}

/**
 * Function to close the navigation sidebar
 */
function closeNav() {
  // Close the sidebar by setting its width to 0
  document.getElementById("mySidebar").style.width = "0";

  // Reset the main content's margin
  document.getElementById("main-content").style.marginLeft = "auto";
}