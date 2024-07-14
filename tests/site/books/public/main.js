import { createRoot } from 'react-dom/client';

// Clear the existing HTML content
//document.body.innerHTML = '<div id="app"></div>';

// Render your React component instead
//const root = createRoot(document.getElementById('app'));
//root.render(<h1>Hello, world</h1>);




const root = ReactDOM.createRoot(
    document.getElementById('app')
  );
  const element = <h1>Hello, world</h1>;
  root.render(element);
  
  
