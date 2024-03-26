import './bootstrap';
import { createRoot } from "react-dom/client";
import { App } from './components/App';
const rootElement = document.getElementById("app");
const root = createRoot(rootElement);

import createApp from '@shopify/app-bridge';
const config = {
    // The client ID provided for your application in the Partner Dashboard.
    apiKey: 'ae6f9e6a0e594f6ad31f53873450dc18',
    shop: new URLSearchParams(location.search).get("shop"),
    // The host of the specific shop that's embedding your app. This value is provided by Shopify as a URL query parameter that's appended to your application URL when your app is loaded inside the Shopify admin.
    host: new URLSearchParams(location.search).get("host"),
    forceRedirect: true
};
const app = createApp(config);
root.render(
      <App />
);