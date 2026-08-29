import './bootstrap';
import Alpine from 'alpinejs';
import {
    createIcons,
    Zap,
    BookOpen,
    Sparkles,
    Layers,
    Search,
    ChevronDown,
    Award,
    Menu,
    X,
    Check,
    ExternalLink,
    Trash2,
    Plus,
    Play,
    Volume2,
    ShieldCheck,
    LayoutDashboard,
    Bookmark,
    BookmarkPlus,
    Timer,
    Library,
    LogOut,
    GraduationCap,
    Gift,
    Mail,
    Lock,
    User,
    Eye,
    EyeOff,
    AlertCircle,
    ArrowLeft,
    ArrowRight,
    FileText,
    FileCheck2,
    Mic,
    Wand2,
    Headphones,
    CheckCircle2,
    XCircle,
    RefreshCw,
    BarChart2,
    Calendar,
    Info,
    HelpCircle
} from 'lucide';

window.Alpine = Alpine;

const appIcons = {
    Zap,
    BookOpen,
    Sparkles,
    Layers,
    Search,
    ChevronDown,
    Award,
    Menu,
    X,
    Check,
    ExternalLink,
    Trash2,
    Plus,
    Play,
    Volume2,
    ShieldCheck,
    LayoutDashboard,
    Bookmark,
    BookmarkPlus,
    Timer,
    Library,
    LogOut,
    GraduationCap,
    Gift,
    Mail,
    Lock,
    User,
    Eye,
    EyeOff,
    AlertCircle,
    ArrowLeft,
    ArrowRight,
    FileText,
    FileCheck2,
    Mic,
    Wand2,
    Headphones,
    CheckCircle2,
    XCircle,
    RefreshCw,
    BarChart2,
    Calendar,
    Info,
    HelpCircle
};

// Lazy loader for Lucide Icons
export function initIcons() {
    createIcons({ icons: appIcons });
}

// Optional lazy loader for ApexCharts
window.loadChart = async () => {
    if (!window.ApexCharts) {
        const { default: ApexCharts } = await import('apexcharts');
        window.ApexCharts = ApexCharts;
    }
    return window.ApexCharts;
};

// Optional lazy loader for Audio Effects & Confetti
window.fireConfetti = async (opts) => {
    const { default: confetti } = await import('canvas-confetti');
    confetti(opts);
};

// Initialize Lucide Icons on DOM ready
document.addEventListener('DOMContentLoaded', () => {
    initIcons();
});

// Re-initialize Lucide icons on Livewire / dynamic DOM updates
document.addEventListener('livewire:navigated', () => {
    initIcons();
});

Alpine.start();
