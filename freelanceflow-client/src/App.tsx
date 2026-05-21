import './App.css'
import {QueryClient, QueryClientProvider} from "@tanstack/react-query";
import {Router} from "./app/Router.tsx";
import ErrorBoundary from "./shared/components/ErrorBoundary.tsx";
import './infrastructure/http/interceptors';

const queryClient = new QueryClient();

function App() {

    return (
        <ErrorBoundary>
            <QueryClientProvider client={queryClient}>
                <Router/>
            </QueryClientProvider>
        </ErrorBoundary>
    )
}

export default App
